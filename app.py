import pandas as pd
from flask import Flask, render_template, request, session, redirect, url_for, flash

app = Flask(__name__)
# SECRET_KEY wajib ada untuk menggunakan session
app.config['SECRET_KEY'] = 'kunci-rahasia-anda-yang-aman'

@app.route('/', methods=['GET', 'POST'])
def home():
    """Menampilkan halaman utama (index.html)."""
    return render_template('index.html')

@app.route('/upload', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        if 'excel_file' not in request.files or not request.files['excel_file'].filename:
            flash('Tidak ada file yang dipilih.', 'danger')
            return redirect(request.url)

        file = request.files['excel_file']
        
        if file and file.filename.endswith('.xlsx'):
            try:
                # PERBAIKAN 1: Baca sheet pertama (index 0), apapun namanya.
                df = pd.read_excel(file, sheet_name=0, engine='openpyxl')
                
                # PERBAIKAN 2: Membersihkan semua nama kolom secara otomatis.
                # Mengubah jadi HURUF BESAR dan menghapus spasi di awal/akhir.
                df.columns = [col.upper().strip() for col in df.columns]
                
                # Cek apakah kolom wajib 'NPP' ada setelah dibersihkan
                if 'NPP' not in df.columns:
                    flash("Error: File Excel tidak memiliki kolom 'NPP'.", 'danger')
                    return redirect(request.url)

                session['excel_data'] = df.to_json(orient='split')
                
                flash(f"File '{file.filename}' berhasil diunggah! Silakan cari data.", 'success')
                return redirect(url_for('search'))

            except Exception as e:
                flash(f"Terjadi error saat membaca file: {e}", 'danger')
                return redirect(request.url)
        else:
            flash("Format file tidak valid. Harap unggah file .xlsx", "danger")
            return redirect(request.url)
    
    return render_template('index.html')

@app.route('/search', methods=['GET', 'POST'])
def search():
    if 'excel_data' not in session:
        flash('Silakan upload file Excel terlebih dahulu.', 'info')
        return redirect(url_for('upload_file'))
        
    df = pd.read_json(session['excel_data'], orient='split')
    
    # Pastikan kolom 'NPP' ada dan bertipe string
    if 'NPP' in df.columns:
        df['NPP'] = df['NPP'].astype(str)
    else:
        # Jika kolom NPP tidak ada (seharusnya tidak terjadi karena sudah dicek saat upload)
        flash("Data yang diunggah tidak valid. Harap unggah ulang file.", "danger")
        return redirect(url_for('upload_file'))

    search_result = None
    if request.method == 'POST':
        npp_id = request.form.get('npp_id')
        
        # PERBAIKAN 3: Pencarian dibuat tidak case-sensitive.
        # Membandingkan keduanya dalam format huruf besar.
        result_row = df[df['NPP'].str.upper() == npp_id.upper()]
        
        if not result_row.empty:
            search_result = result_row.iloc[0].to_dict()

    return render_template('index.html', result=search_result)

if __name__ == '__main__':
    app.run(debug=True, port=8000)