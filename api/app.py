from flask import Flask, request, jsonify
import cv2
import numpy as np
import base64
import os

app = Flask(__name__)

# ==========================================
# 1. SETUP GLOBAL & DATABASE
# ==========================================
print("--- MEMULAI APLIKASI COIN VISION (SUPER RES + WATERSHED) ---")

# Fitur extraction object
ORB = cv2.ORB_create(nfeatures=2000)
DATABASE_DESCRIPTORS = {}

# --- [BARU] SETUP AI SUPER RESOLUTION ---
# Inisialisasi object Super Resolution
sr = cv2.dnn_superres.DnnSuperResImpl_create()

# Tentukan path model (Pastikan file .pb ada di folder yang sama)
model_path = "FSRCNN_x3.pb" 

# Cek apakah file model ada agar tidak error jika lupa download
if os.path.exists(model_path):
    try:
        sr.readModel(model_path)
        # Set model ke FSRCNN dengan skala 3x (perbesar 3 kali)
        sr.setModel("fsrcnn", 3) 
        print("[INFO] Model AI Super Resolution (FSRCNN) BERHASIL dimuat.")
    except Exception as e:
        print(f"[ERROR] Gagal memuat model SR: {e}")
else:
    print(f"[WARNING] File '{model_path}' tidak ditemukan! Fitur HD dimatikan.")
# ----------------------------------------

# Metadata Koin
COIN_DB = {
    "100": { "bahan": "Aluminium", "asal": "Bank Indonesia", "tahun": "2016", "sumber": "Ref Image" },
    "200": { "bahan": "Aluminium", "asal": "Bank Indonesia", "tahun": "2016", "sumber": "Ref Image" },
    "500": { "bahan": "Aluminium", "asal": "Bank Indonesia", "tahun": "2016", "sumber": "Ref Image" },
    "1000": { "bahan": "Nikel", "asal": "Bank Indonesia", "tahun": "2010", "sumber": "Ref Image" }
}

def load_references():
    """Memuat gambar referensi koin untuk pencocokan ORB"""
    ref_path = "ref_coins"
    if not os.path.exists(ref_path):
        os.makedirs(ref_path)
        print(f"[INFO] Folder '{ref_path}' dibuat. Harap isi dengan 100.jpg, 200.jpg, dst.")
        return

    print("[INFO] Memuat database referensi...")
    for filename in os.listdir(ref_path):
        if filename.lower().endswith(('.png', '.jpg', '.jpeg')):
            nominal = filename.split('.')[0] 
            img = cv2.imread(os.path.join(ref_path, filename), 0)
            if img is not None:
                _, des = ORB.detectAndCompute(img, None)
                if des is not None:
                    DATABASE_DESCRIPTORS[nominal] = des
                    print(f"  > Loaded: {nominal}")

load_references()

# ==========================================
# 2. UTILITY FUNCTIONS (AUTO-REPAIR + SUPER RES)
# ==========================================
def decode_image(image_data):
    if image_data.startswith(b'data:image') or image_data.startswith(b'data:application'):
        header, encoded = image_data.split(b',', 1)
        nparr = np.frombuffer(base64.b64decode(encoded), np.uint8)
    else:
        nparr = np.frombuffer(image_data, np.uint8)
    return cv2.imdecode(nparr, cv2.IMREAD_COLOR)

def img_to_base64(img):
    _, buffer = cv2.imencode('.jpg', img)
    return f"data:image/jpeg;base64,{base64.b64encode(buffer).decode('utf-8')}"

def perbaiki_kualitas_citra(img):
    """
    Fungsi 'Dandan' Gambar:
    1. [BARU] AI Upscaling (Jika gambar kecil/buram)
    2. CLAHE (Perbaikan Cahaya)
    """
    
    # --- [BARU] TAHAP 1: AI UPSCALING ---
    # Kita hanya lakukan ini jika model berhasil dimuat di awal
    # Dan jika lebar gambar < 1000px (agar proses tidak terlalu lama)
    h, w = img.shape[:2]
    
    # Cek apakah model sudah siap (tidak kosong)
    if w < 1000 and os.path.exists(model_path):
        try:
            # print("[INFO] Mengaktifkan AI Upscaling...") # Uncomment untuk debug
            # Proses Upscaling (Sihir HD)
            img = sr.upsample(img)
            
            # Opsional: Jika hasil upscaling terlalu raksasa, kecilkan sedikit 
            # supaya Watershed tidak lemot.
            h_new, w_new = img.shape[:2]
            if w_new > 1600:
                scale = 1600 / w_new
                img = cv2.resize(img, None, fx=scale, fy=scale)
                
        except Exception as e:
            print(f"[ERROR] Upscaling gagal, lanjut proses biasa: {e}")

    # --- TAHAP 2: PERBAIKAN CAHAYA (CLAHE) ---
    # Kode CLAHE lama Anda (TANPA SHARPENING)
    lab = cv2.cvtColor(img, cv2.COLOR_BGR2LAB)
    l, a, b = cv2.split(lab)
    
    clahe = cv2.createCLAHE(clipLimit=2.0, tileGridSize=(8,8))
    cl = clahe.apply(l)
    
    limg = cv2.merge((cl,a,b))
    enhanced = cv2.cvtColor(limg, cv2.COLOR_LAB2BGR)
    
    return enhanced

def klasifikasi_radius(radius):
    if radius < 32: return 100
    elif 32 <= radius < 38: return 200
    elif 38 <= radius < 44: return 500
    elif radius >= 44: return 1000
    return 0

# ==========================================
# 3. ALGORITMA 1: SCAN BIASA (Tetap Sama)
# ==========================================
def process_biasa(img):
    output = img.copy()
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    blurred = cv2.GaussianBlur(gray, (15, 15), 0)
    thresh = cv2.adaptiveThreshold(blurred, 255, 
        cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY_INV, 11, 2)
    contours, _ = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    
    # Setup FLANN
    index_params = dict(algorithm=6, table_number=6, key_size=12, multi_probe_level=1)
    search_params = dict(checks=50)
    flann = cv2.FlannBasedMatcher(index_params, search_params)

    rincian = []
    
    for cnt in contours:
        area = cv2.contourArea(cnt)
        if area > 1000:
            ((x, y), radius) = cv2.minEnclosingCircle(cnt)
            x_int, y_int, r_int = int(x), int(y), int(radius)
            y1, y2 = max(0, y_int-r_int), min(gray.shape[0], y_int+r_int)
            x1, x2 = max(0, x_int-r_int), min(gray.shape[1], x_int+r_int)
            roi = gray[y1:y2, x1:x2]
            
            best_nominal = 0
            max_matches = 0
            match_method = "Radius (Fallback)"

            if roi.size > 0:
                roi_mask = np.zeros_like(roi)
                h_r, w_r = roi.shape
                cv2.circle(roi_mask, (w_r//2, h_r//2), r_int, 255, -1)

                try:
                    kp_scene, des_scene = ORB.detectAndCompute(roi, mask=roi_mask)
                    if des_scene is not None and len(DATABASE_DESCRIPTORS) > 0:
                        for nominal, des_ref in DATABASE_DESCRIPTORS.items():
                            matches = flann.knnMatch(des_ref, des_scene, k=2)
                            good = [m for m, n in matches if m.distance < 0.75 * n.distance]
                            if len(good) > max_matches:
                                max_matches = len(good)
                                best_nominal = int(nominal)
                except: pass

                if max_matches > 4:
                    match_method = f"Contour+ORB ({max_matches})"
                else:
                    best_nominal = 0

            if best_nominal == 0:
                best_nominal = klasifikasi_radius(radius)
                match_method = "Radius Only (Unreliable)"

            meta = COIN_DB.get(str(best_nominal), {"bahan":"?","tahun":"?","sumber":"-"})
            rincian.append({
                "jenis": f"Rp {best_nominal}", 
                "radius": int(radius), 
                "nilai": best_nominal, 
                "info": {"sumber": match_method, "bahan": meta['bahan']}
            })
            
            color = (0, 255, 0) if "ORB" in match_method else (0, 0, 255)
            cv2.circle(output, (int(x), int(y)), int(radius), color, 2)
            cv2.putText(output, str(best_nominal), (int(x)-20, int(y)), 
                        cv2.FONT_HERSHEY_SIMPLEX, 0.6, (255, 0, 0), 2)

    return rincian, output, thresh

# ==========================================
# 4. ALGORITMA 2: SCAN PREMIUM (Tetap Sama)
# ==========================================
def process_watershed_orb(img):
    output = img.copy()
    invGamma = 1.0 / 1.5
    table = np.array([((i / 255.0) ** invGamma) * 255 for i in np.arange(0, 256)]).astype("uint8")
    img_gamma = cv2.LUT(img, table)
    gray = cv2.cvtColor(img_gamma, cv2.COLOR_BGR2GRAY)

    blurred = cv2.GaussianBlur(gray, (21, 21), 0)
    ret, thresh = cv2.threshold(blurred, 0, 255, cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)

    kernel = np.ones((3,3), np.uint8)
    closing = cv2.morphologyEx(thresh, cv2.MORPH_CLOSE, kernel, iterations=3)
    opening = cv2.morphologyEx(closing, cv2.MORPH_OPEN, kernel, iterations=2)
    
    sure_bg = cv2.dilate(opening, kernel, iterations=3)
    dist_transform = cv2.distanceTransform(opening, cv2.DIST_L2, 5)
    ret, sure_fg = cv2.threshold(dist_transform, 0.15 * dist_transform.max(), 255, 0)

    sure_fg = np.uint8(sure_fg)
    unknown = cv2.subtract(sure_bg, sure_fg)

    ret, markers = cv2.connectedComponents(sure_fg)
    markers = markers + 1
    markers[unknown == 255] = 0

    markers = cv2.watershed(img_gamma, markers)
    
    index_params = dict(algorithm=6, table_number=6, key_size=12, multi_probe_level=1)
    search_params = dict(checks=50)
    flann = cv2.FlannBasedMatcher(index_params, search_params)

    rincian = []
    unique_markers = np.unique(markers)
    debug_view = cv2.cvtColor(sure_fg * 255, cv2.COLOR_GRAY2BGR)

    for label in unique_markers:
        if label <= 1: continue 

        mask = np.zeros(gray.shape, dtype="uint8")
        mask[markers == label] = 255

        cnts, _ = cv2.findContours(mask.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        
        if len(cnts) > 0:
            c = max(cnts, key=cv2.contourArea)
            ((x, y), radius) = cv2.minEnclosingCircle(c)
            
            if radius < 18: continue

            x_int, y_int, r_int = int(x), int(y), int(radius)
            y1, y2 = max(0, y_int-r_int), min(gray.shape[0], y_int+r_int)
            x1, x2 = max(0, x_int-r_int), min(gray.shape[1], x_int+r_int)
            roi = gray[y1:y2, x1:x2]

            best_nominal = 0
            max_matches = 0
            match_method = "Radius (Fallback)"

            if roi.size > 0:
                roi_mask = np.zeros_like(roi)
                h_r, w_r = roi.shape
                cv2.circle(roi_mask, (w_r//2, h_r//2), r_int, 255, -1)
                roi_detail = gray[y1:y2, x1:x2]

                try:
                    kp_scene, des_scene = ORB.detectAndCompute(roi_detail, mask=roi_mask)
                    if des_scene is not None and len(DATABASE_DESCRIPTORS) > 0:
                        for nominal, des_ref in DATABASE_DESCRIPTORS.items():
                            matches = flann.knnMatch(des_ref, des_scene, k=2)
                            good = [m for m, n in matches if m.distance < 0.75 * n.distance]
                            if len(good) > max_matches:
                                max_matches = len(good)
                                best_nominal = int(nominal)
                except: pass
                
                if max_matches > 4:
                    match_method = f"Wtr+ORB ({max_matches})"
                else:
                    best_nominal = 0

            if best_nominal == 0:
                best_nominal = klasifikasi_radius(radius)

            meta = COIN_DB.get(str(best_nominal), {"bahan":"?","tahun":"?","sumber":"-"})
            rincian.append({
                "jenis": f"Rp {best_nominal}", 
                "radius": int(radius), 
                "nilai": best_nominal, 
                "info": { "sumber": match_method, "bahan": meta['bahan'] }
            })

            cv2.circle(output, (int(x), int(y)), int(radius), (0, 255, 0), 2)
            cv2.putText(output, str(best_nominal), (int(x)-20, int(y)), 
                       cv2.FONT_HERSHEY_SIMPLEX, 0.6, (255,0,0), 2)

    return rincian, output, debug_view

# ==========================================
# 5. API ROUTES
# ==========================================
@app.route('/proses', methods=['POST'])
def api_proses():
    mode = request.form.get('mode', 'biasa')
    img_bytes = None
    
    if 'camera_image' in request.form and request.form['camera_image']:
        img_bytes = request.form['camera_image'].encode('utf-8')
    elif 'file_gambar' in request.files:
        img_bytes = request.files['file_gambar'].read()
        
    if not img_bytes: 
        return jsonify({"status": "gagal", "pesan": "Gambar kosong"}), 400
    
    try:
        img = decode_image(img_bytes)
        
        # 1. RESIZE AWAL (Jangan terlalu kecil agar Super Res bekerja)
        # Kita naikkan sedikit batasnya ke 1000px
        h, w = img.shape[:2]
        if w > 1000: img = cv2.resize(img, (1000, int(h * (1000/w))))

        # 2. AUTO-REPAIR (SEKARANG SUDAH ADA AI SUPER RES DI DALAMNYA)
        # Fungsi ini sekarang akan membesarkan gambar kecil menjadi HD
        img = perbaiki_kualitas_citra(img)

        # 3. ROUTING ALGORITMA
        if mode == 'premium':
            data, res_img, dbg_img = process_watershed_orb(img)
            mtd = "Scan Premium (SuperRes+Watershed+ORB)"
        else:
            data, res_img, dbg_img = process_biasa(img)
            mtd = "Scan Biasa (SuperRes+Contour+ORB)"
            
        total = sum(x['nilai'] for x in data)
        
        return jsonify({
            "status": "sukses",
            "metode": mtd,
            "total_rupiah": total,
            "jumlah_koin": len(data),
            "data_rinci": data,
            "img_final": img_to_base64(res_img),
            "img_edge": img_to_base64(dbg_img)
        })
    except Exception as e:
        print("ERROR:", str(e))
        return jsonify({"status": "error", "pesan": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, port=5001, host='0.0.0.0')