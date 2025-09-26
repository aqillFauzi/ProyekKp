# Import library yang dibutuhkan
import pandas as pd
from flask import Flask, render_template, request, session, redirect, url_for, flash
import sqlite3

# Inisialisasi Flask app
app = Flask(__name__)
app.config['SECRET_KEY'] = 'kunci-rahasia-anda-yang-aman'

# Nama database SQLite
DB_NAME = "database.db"

# Helper: buat tabel SQLite jika belum ada
def init_db():
    conn = sqlite3.connect(DB_NAME)
    cursor = conn.cursor()
    cursor.execute("""
        CREATE TABLE IF NOT EXISTS pekerja (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            kode_kantor TEXT,
            npp TEXT UNIQUE,
            divisi TEXT,
            nama_perusahaan TEXT,
            tk_aktif INTEGER,
            tk_sudah_jmo INTEGER,
            tk_belum_jmo INTEGER
        )
    """)
    conn.commit()
    conn.close()

init_db()  # jalankan sekali saat start

# Route dan logic aplikasi
@app.route('/')
def home():
    """Halaman utama"""
    return render_template('index.html')

# Route untuk upload file Excel
@app.route('/upload', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        if 'excel_file' not in request.files or not request.files['excel_file'].filename:
            flash('Tidak ada file yang dipilih.', 'danger')
            return redirect(request.url)

        file = request.files['excel_file']
        
        if file and file.filename.endswith('.xlsx'):
            try:
                # Baca file Excel sheet pertama
                df = pd.read_excel(file, sheet_name=0, engine='openpyxl')
                df.columns = [col.upper().strip() for col in df.columns]

                # Pastikan kolom NPP ada
                if 'NPP' not in df.columns:
                    flash("Error: File Excel tidak memiliki kolom 'NPP'.", 'danger')
                    return redirect(request.url)

                # Simpan data ke SQLite
                conn = sqlite3.connect(DB_NAME)
                cursor = conn.cursor()

                for _, row in df.iterrows():
                    cursor.execute("""
                        INSERT OR REPLACE INTO pekerja 
                        (kode_kantor, npp, divisi, nama_perusahaan, tk_aktif, tk_sudah_jmo, tk_belum_jmo)
                        VALUES (?, ?, ?, ?, ?, ?, ?)
                    """, (
                        str(row.get("KODE KANTOR", "")),
                        str(row.get("NPP", "")),
                        str(row.get("DIVISI", "")),
                        str(row.get("NAMA PERUSAHAAN", "")),
                        int(row.get("TK AKTIF", 0)),
                        int(row.get("TK SUDAH JMO", 0)),
                        int(row.get("TK BELUM JMO", 0))
                    ))

                conn.commit()
                conn.close()

                flash(f"File '{file.filename}' berhasil diunggah dan data tersimpan di database!", 'success')
                return redirect(url_for('search'))

            except Exception as e:
                flash(f"Terjadi error saat membaca file: {e}", 'danger')
                return redirect(request.url)
        else:
            flash("Format file tidak valid. Harap unggah file .xlsx", "danger")
            return redirect(request.url)
    
    return render_template('upload.html')

# Route untuk pencarian berdasarkan NPP
@app.route('/search', methods=['GET', 'POST'])
def search():
    search_result = None
    if request.method == 'POST':
        npp_id = request.form.get('npp_id')
        conn = sqlite3.connect(DB_NAME)
        cursor = conn.cursor()
        cursor.execute("""
            SELECT nama_perusahaan, tk_aktif, tk_sudah_jmo, tk_belum_jmo
            FROM pekerja WHERE UPPER(npp) = ?
        """, (npp_id.upper(),))
        row = cursor.fetchone()
        conn.close()

        if row:
            search_result = {
                "NAMA PERUSAHAAN": row[0],
                "TK AKTIF": row[1],
                "TK SUDAH JMO": row[2],
                "TK BELUM JMO": row[3]
            }

    return render_template('search.html', result=search_result)

# Jalankan aplikasi
if __name__ == '__main__':
    app.run(debug=True, port=8000)
