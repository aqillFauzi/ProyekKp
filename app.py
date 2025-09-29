import pandas as pd
from flask import Flask, render_template, request, session, redirect, url_for, flash

app = Flask(__name__)
app.config['SECRET_KEY'] = 'kunci-rahasia-anda-yang-aman'

@app.route('/', methods=['GET', 'POST'])
def index():
    search_result = None

    # Jika user upload file Excel
    if 'excel_file' in request.files:
        file = request.files['excel_file']
        if file and file.filename.endswith('.xlsx'):
            try:
                df = pd.read_excel(file, sheet_name=0, engine='openpyxl')
                df.columns = [col.upper().strip() for col in df.columns]

                if 'NPP' not in df.columns:
                    flash("Error: File Excel tidak memiliki kolom 'NPP'.", "danger")
                    return redirect(url_for('index'))

                df['NPP'] = df['NPP'].astype(str).str.strip()
                session['excel_data'] = df.to_json(orient='split')

                flash(f"File '{file.filename}' berhasil diunggah!", "success")
                # redirect langsung ke bagian search
                return redirect(url_for('index') + "#search")

            except Exception as e:
                flash(f"Terjadi error saat membaca file: {e}", "danger")
                return redirect(url_for('index'))
        else:
            flash("Format file tidak valid. Harap unggah file .xlsx", "danger")
            return redirect(url_for('index'))

    # Jika user melakukan search
    if request.form.get('npp_id'):
        if 'excel_data' not in session:
            flash("Silakan upload file Excel terlebih dahulu.", "info")
            return redirect(url_for('index'))

        df = pd.read_json(session['excel_data'], orient='split')
        df['NPP'] = df['NPP'].astype(str).str.strip()

        npp_id = request.form.get('npp_id').strip()
        result_row = df[df['NPP'].str.upper() == npp_id.upper()]

        if not result_row.empty:
            search_result = result_row.iloc[0].to_dict()
        else:
            flash("Data tidak ditemukan.", "warning")

    return render_template("index.html", result=search_result)


if __name__ == '__main__':
    app.run(debug=True, port=8000)