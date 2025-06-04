<h3>Form Data</h3>
<form action="javascript:void(0)" id="frm-csv" method="get" enctype="multipart/form-data">
    <p>
        <label for="csv_data_file">Upload CSV File</label><br>
        <input type="file" name="csv_data_file" id="csv_data_file" accept=".csv" required>
        <input type="hidden" name="action" value="cdu_submit_csv_data">
    </p>
    <p>
        <button type="submit">Upload CSV</button>
    </p>
</form>      