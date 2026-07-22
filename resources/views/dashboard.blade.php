<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SI-WISMAN - Kementerian Luar Negeri</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('Logo-Kemenlu-Dianisa.com.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; color: #1e293b; }
        
        /* Navbar Styling */
        .navbar-custom { background-color: #ffffff; border-bottom: 1px solid #e2e8f0; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); padding: 0.75rem 0; z-index: 1030; }
        .navbar-brand img { height: 55px; }
        .kemenlu-title { font-weight: 700; color: #0f172a; margin: 0; font-size: 1.25rem; letter-spacing: -0.025em; }
        .kemenlu-subtitle { font-size: 0.8rem; color: #64748b; margin: 0; font-weight: 500; }
        .app-title { font-weight: 700; color: #0f4a8a; font-size: 1.1rem; letter-spacing: -0.01em; }
        
        /* Cards Styling */
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); margin-bottom: 24px; overflow: hidden; border-top: 3px solid transparent; }
        .card.card-accent { border-top-color: #f59e0b; }
        .card-header { background-color: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 1.25rem 1.5rem; display: flex; align-items: center; }
        .icon-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .bg-primary-subtle { background-color: #eff6ff !important; }
        .text-primary { color: #0f4a8a !important; }
        
        /* Summary Cards */
        .stat-card .card-body { display: flex; align-items: center; padding: 1.5rem; }
        .stat-icon { width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 1.25rem; flex-shrink: 0; }
        .stat-icon-1 { background-color: #eff6ff; color: #0f4a8a; border: 1px solid #bfdbfe; }
        .stat-icon-2 { background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
        .stat-icon-3 { background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .stat-content { flex: 1; }
        .stat-label { font-size: 0.875rem; color: #64748b; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-value { font-size: 1.75rem; font-weight: 700; color: #0f172a; line-height: 1; }
        
        /* Modern Buttons */
        .btn { border-radius: 4px; font-weight: 500; padding: 0.5rem 1.25rem; transition: all 0.2s ease; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .btn-success { background-color: #10b981; border-color: #10b981; }
        .btn-success:hover { background-color: #059669; border-color: #059669; }
        .btn-warning { background-color: #f59e0b; border-color: #f59e0b; color: #fff; }
        .btn-warning:hover { color: #fff; background-color: #d97706; border-color: #d97706; }
        .btn-danger { background-color: #ef4444; border-color: #ef4444; }
        .btn-danger:hover { background-color: #dc2626; border-color: #dc2626; }
        .btn-primary { background-color: #0f4a8a; border-color: #0f4a8a; }
        .btn-primary:hover { background-color: #1e3a8a; border-color: #1e3a8a; }

        /* Footer Styling */
        .footer-kemenlu { background: linear-gradient(135deg, #0f4a8a 0%, #1e3a8a 100%); border-top: 4px solid #f59e0b; border-radius: 12px 12px 0 0; }
        .footer-kemenlu a.hover-white:hover { color: #f59e0b !important; }

        /* Map & Table Styling */
        #geomap { width: 100%; height: 500px; background-color: #e0f2fe; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; }
        .table { color: #334155; margin-bottom: 0; }
        .table thead th { background-color: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem; }
        .table tbody td { vertical-align: middle; border-bottom: 1px solid #e2e8f0; padding: 1rem; font-size: 0.95rem; }
        .table-striped>tbody>tr:nth-of-type(odd)>* { background-color: #f8fafc; }
        
        /* Removed duplicate Buttons block */
        /* Footer */
        .footer-kemenlu { background-color: #0f4a8a; border-top: 4px solid #f59e0b; }
        .footer-kemenlu .hover-white:hover { color: #ffffff !important; }
        .chat-fab { position: fixed; bottom: 30px; left: 30px; width: 60px; height: 60px; border-radius: 50%; background-color: #0f4a8a; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 4px 12px rgba(15, 74, 138, 0.4); cursor: pointer; z-index: 1050; transition: transform 0.2s; }
        .chat-fab:hover { transform: scale(1.05); }

        #geomap { z-index: 1; border-radius: 8px; } /* Leaflet z-index fix */
        .leaflet-popup-content-wrapper { border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 0; overflow: hidden; border: none; }
        .leaflet-popup-content { margin: 0; line-height: normal; }
        .leaflet-tooltip-custom { background: transparent !important; border: none !important; box-shadow: none !important; padding: 0 !important; }
        .leaflet-tooltip-custom::before { display: none !important; } /* Hide tooltip arrow */
        .chat-popup { position: fixed; bottom: 100px; left: 30px; width: 350px; background: #ffffff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1050; display: none; overflow: hidden; border: 1px solid #e2e8f0; }
        .chat-header { background: #0f4a8a; color: white; padding: 15px; font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
        .chat-close { cursor: pointer; color: white; }
        .chat-container { height: 350px; overflow-y: auto; padding: 1.5rem; background: #f8fafc; }
        .chat-form-container { padding: 15px; border-top: 1px solid #e2e8f0; background: #fff; }
        .chat-message { margin-bottom: 1rem; display: flex; flex-direction: column; }
        .chat-message.user { align-items: flex-end; }
        .chat-message.user .bubble { background-color: #0f4a8a; color: white; border-bottom-right-radius: 4px; }
        .chat-message.ai { align-items: flex-start; }
        .chat-message.ai .bubble { background-color: #ffffff; color: #334155; border: 1px solid #e2e8f0; border-bottom-left-radius: 4px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .bubble { padding: 0.875rem 1.125rem; border-radius: 16px; max-width: 85%; font-size: 0.95rem; line-height: 1.5; }
        
        /* Highcharts Tooltip */
        .highcharts-tooltip-box { display: none; }
        
        /* Skeleton Loader */
        .skeleton { background: linear-gradient(90deg, #e2e8f0 25%, #f8fafc 50%, #e2e8f0 75%); background-size: 200% 100%; animation: skeleton-loading 1.5s infinite; border-radius: 4px; }
        @keyframes skeleton-loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        .skeleton-text { height: 12px; margin-bottom: 8px; width: 100%; }
        .skeleton-text.short { width: 60%; margin-bottom: 0; }
        .skeleton-bubble { min-width: 150px; padding: 1.25rem 1.125rem !important; }
    </style>
</head>
<body>

<!-- Corporate Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <div class="d-flex align-items-center">
            <!-- Logo Kemenlu Lokal -->
            <img src="{{ asset('Logo-Kemenlu-Dianisa.com.ico') }}" alt="Logo Kemenlu" class="me-3" height="40">
            <div>
                <h1 class="kemenlu-title">SI-WISMAN</h1>
                <p class="kemenlu-subtitle">Sistem Informasi Wisatawan Mancanegara</p>
            </div>
        </div>
    </div>
</nav>

<div class="container py-4">
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon stat-icon-1"><i class="fas fa-globe-americas"></i></div>
                    <div class="stat-content">
                        <div class="stat-label">Total Negara Terdaftar</div>
                        <div class="stat-value">{{ $totalNegara }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon stat-icon-2"><i class="fas fa-plane-arrival"></i></div>
                    <div class="stat-content">
                        <div class="stat-label">Wisatawan (Bulan Terakhir)</div>
                        <div class="stat-value">{{ number_format($totalWisatawan, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon stat-icon-3"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-content">
                        <div class="stat-label">Total Periode Bulan</div>
                        <div class="stat-value">{{ $totalBulan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GeoMap -->
    <div class="card card-accent mb-4">
        <div class="card-header justify-content-between">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-primary-subtle text-primary me-3">
                    <i class="fas fa-globe-asia fs-5"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color: #0f4a8a; letter-spacing: -0.01em;">Peta Persebaran Wisatawan (Bulan Terakhir)</h5>
            </div>
            <select id="regionFilter" class="form-select" style="width: 200px; border-radius: 4px;">
                <option value="world">Seluruh Dunia</option>
                <option value="asia">Asia</option>
                <option value="asia_tenggara">Asia Tenggara</option>
                <option value="asia_timur">Asia Timur</option>
                <option value="eropa">Eropa</option>
                <option value="amerika">Amerika</option>
                <option value="afrika">Afrika</option>
                <option value="oseania">Oseania</option>
            </select>
        </div>
        <div class="card-body p-0">
            <div id="geomap"></div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card card-accent h-100">
                <div class="card-header d-flex align-items-center">
                    <div class="icon-circle bg-primary-subtle text-primary me-3">
                        <i class="fas fa-chart-column fs-5"></i>
                    </div>
                    <h5 class="mb-0 fw-bold" style="color: #0f4a8a;">Top 5 Negara Asal (Mei)</h5>
                </div>
                <div class="card-body">
                    <div id="barChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-accent h-100">
                <div class="card-header d-flex align-items-center">
                    <div class="icon-circle bg-primary-subtle text-primary me-3">
                        <i class="fas fa-chart-pie fs-5"></i>
                    </div>
                    <h5 class="mb-0 fw-bold" style="color: #0f4a8a;">Proporsi Wisatawan Bulanan</h5>
                </div>
                <div class="card-body">
                    <div id="pieChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <div class="card card-accent">
        <div class="card-header justify-content-between">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-primary-subtle text-primary me-3">
                    <i class="fas fa-table fs-5"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color: #0f4a8a;">Data Rekapitulasi Wisatawan</h5>
            </div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus me-1"></i> Tambah Data</button>
        </div>
        <div class="card-body">
            <table id="wisatawanTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Negara</th>
                        <th>Januari</th>
                        <th>Februari</th>
                        <th>Maret</th>
                        <th>April</th>
                        <th>Mei</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="footer-kemenlu mt-5 py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0 d-flex align-items-center">
                <img src="{{ asset('Logo-Kemenlu-Dianisa.com.ico') }}" alt="Logo Kemenlu" height="60" class="me-4 bg-white p-2 rounded">
                <div>
                    <h5 class="text-white fw-bold mb-1">KEMENTERIAN LUAR NEGERI</h5>
                    <p class="text-white-50 mb-0 small">Sistem Informasi Wisatawan Mancanegara (SI-WISMAN)</p>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white-50 me-3 text-decoration-none hover-white">Portal Kemenlu</a>
                <a href="#" class="text-white-50 me-3 text-decoration-none hover-white">e-Konsuler</a>
                <a href="#" class="text-white-50 text-decoration-none hover-white">Pusat Bantuan</a>
                <div class="mt-2 text-white-50 small">&copy; 2026 Hak Cipta Dilindungi.</div>
            </div>
        </div>
    </div>
</footer>

<!-- Floating AI Chatbot -->
<div class="chat-fab" id="chatFab">
    <i class="fas fa-robot"></i>
</div>

<div class="chat-popup" id="chatPopup">
    <div class="chat-header">
        <span><i class="fas fa-robot me-2"></i> AI Assistant SI-WISMAN</span>
        <span class="chat-close" id="chatClose"><i class="fas fa-times"></i></span>
    </div>
    <div class="chat-container" id="chatBox">
        <div class="chat-message ai">
            <div class="bubble" style="width: 100%; max-width: 100%;">
                <div class="fw-bold mb-1"><i class="fas fa-info-circle text-primary"></i> About this AI</div>
                <small class="d-block mb-2 text-muted">Saya adalah asisten virtual cerdas yang dapat menganalisis data kunjungan wisatawan mancanegara ke Indonesia.</small>
                <div class="fw-bold mb-1 mt-3" style="font-size: 0.85em; color: #64748b;">Coba tanyakan:</div>
                <div class="d-flex flex-wrap gap-1 mt-1">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle p-2 text-start fw-normal" style="cursor:pointer; white-space:normal; text-align:left;" onclick="$('#chatInput').val('Negara mana penyumbang wisatawan terbanyak?'); $('#chatForm').submit();">Negara mana penyumbang wisatawan terbanyak?</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle p-2 text-start fw-normal" style="cursor:pointer; white-space:normal; text-align:left;" onclick="$('#chatInput').val('Bagaimana tren kunjungan dari wilayah Asia Tenggara?'); $('#chatForm').submit();">Bagaimana tren kunjungan dari Asia Tenggara?</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle p-2 text-start fw-normal" style="cursor:pointer; white-space:normal; text-align:left;" onclick="$('#chatInput').val('Tolong buatkan kesimpulan tren bulan Mei.'); $('#chatForm').submit();">Buatkan kesimpulan tren bulan Mei</span>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-form-container">
        <form id="chatForm">
            <div class="input-group">
                <input type="text" id="chatInput" class="form-control" placeholder="Tanyakan sesuatu..." autocomplete="off" required>
                <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Data Wisatawan: <span id="editCountryName"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editCountryId" name="id_negara">
            <div class="mb-3">
                <label>Januari</label>
                <input type="number" class="form-control" id="editJan" name="jan" required>
            </div>
            <div class="mb-3">
                <label>Februari</label>
                <input type="number" class="form-control" id="editFeb" name="feb" required>
            </div>
            <div class="mb-3">
                <label>Maret</label>
                <input type="number" class="form-control" id="editMar" name="mar" required>
            </div>
            <div class="mb-3">
                <label>April</label>
                <input type="number" class="form-control" id="editApr" name="apr" required>
            </div>
            <div class="mb-3">
                <label>Mei</label>
                <input type="number" class="form-control" id="editMei" name="mei" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btnSave">Save</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addForm">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Tambah Data Wisatawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label>Nama Negara</label>
                <input type="text" class="form-control" id="addCountryName" name="nama_negara" placeholder="Pilih atau ketik nama negara..." list="negaraList" autocomplete="off" required>
                <datalist id="negaraList">
                    @foreach($listNegara as $n)
                        <option value="{{ $n }}"></option>
                    @endforeach
                </datalist>
                <small class="text-muted">Pilih dari daftar. Jika tidak ada, tidak dapat ditambahkan.</small>
            </div>
            <div class="mb-3">
                <label>Januari</label>
                <input type="number" class="form-control" name="jan" value="0" required>
            </div>
            <div class="mb-3">
                <label>Februari</label>
                <input type="number" class="form-control" name="feb" value="0" required>
            </div>
            <div class="mb-3">
                <label>Maret</label>
                <input type="number" class="form-control" name="mar" value="0" required>
            </div>
            <div class="mb-3">
                <label>April</label>
                <input type="number" class="form-control" name="apr" value="0" required>
            </div>
            <div class="mb-3">
                <label>Mei</label>
                <input type="number" class="form-control" name="mei" value="0" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btnAddSave">Tambah</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Setup CSRF Token for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // Init DataTable
        var table = $('#wisatawanTable').DataTable({
            processing: true,
            pageLength: 10,
            ajax: "{{ route('dashboard.datatable') }}",
            columns: [
                { data: 'no' },
                { data: 'nama_negara' },
                { data: 'Jan' },
                { data: 'Feb' },
                { data: 'Mar' },
                { data: 'Apr' },
                { data: 'Mei' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<button class="btn btn-sm btn-warning btn-edit" data-id="${row.id_negara}" data-name="${row.nama_negara}" data-jan="${row.Jan}" data-feb="${row.Feb}" data-mar="${row.Mar}" data-apr="${row.Apr}" data-mei="${row.Mei}"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id_negara}"><i class="fas fa-trash"></i> Delete</button>`;
                    }
                }
            ],
            responsive: true
        });

        // Edit Action
        $('#wisatawanTable tbody').on('click', '.btn-edit', function() {
            var btn = $(this);
            $('#editCountryId').val(btn.data('id'));
            $('#editCountryName').text(btn.data('name'));
            $('#editJan').val(btn.data('jan'));
            $('#editFeb').val(btn.data('feb'));
            $('#editMar').val(btn.data('mar'));
            $('#editApr').val(btn.data('apr'));
            $('#editMei').val(btn.data('mei'));
            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        });

        // Submit Edit Form
        $('#editForm').submit(function(e) {
            e.preventDefault();
            $('#btnSave').text('Saving...').prop('disabled', true);
            $.ajax({
                url: "{{ route('dashboard.update') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    $('#btnSave').text('Save').prop('disabled', false);
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                    drawRegionsMap(); // reload geomap
                    Swal.fire('Berhasil!', 'Data telah diupdate.', 'success');
                },
                error: function(err) {
                    $('#btnSave').text('Save').prop('disabled', false);
                    Swal.fire('Error!', 'Gagal mengupdate data.', 'error');
                }
            });
        });

        // Submit Add Form
        $('#addForm').submit(function(e) {
            e.preventDefault();
            $('#btnAddSave').text('Menambahkan...').prop('disabled', true);
            $.ajax({
                url: "{{ route('dashboard.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    $('#btnAddSave').text('Tambah').prop('disabled', false);
                    $('#addModal').modal('hide');
                    $('#addForm')[0].reset();
                    table.ajax.reload();
                    drawRegionsMap(); // reload geomap
                    Swal.fire('Berhasil!', 'Data baru telah ditambahkan.', 'success');
                },
                error: function(err) {
                    $('#btnAddSave').text('Tambah').prop('disabled', false);
                    let msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Gagal menambahkan data.';
                    Swal.fire('Error!', msg, 'error');
                }
            });
        });

        // Delete Action
        $('#wisatawanTable tbody').on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('dashboard.delete') }}",
                        type: "POST",
                        data: { id_negara: id },
                        success: function(res) {
                            table.ajax.reload();
                            drawRegionsMap(); // reload geomap
                            Swal.fire('Deleted!', 'Data has been deleted.', 'success');
                        }
                    });
                }
            });
        });

        // Chatbot Toggle Logic
        $('#chatFab').click(function() {
            $('#chatPopup').fadeToggle();
            $('#chatInput').focus();
        });
        
        $('#chatClose').click(function() {
            $('#chatPopup').fadeOut();
        });

        // Chatbot Action
        $('#chatForm').submit(function(e) {
            e.preventDefault();
            var input = $('#chatInput').val();
            if(!input) return;
            
            // Append User Question
            $('#chatBox').append(`
                <div class="chat-message user">
                    <div class="bubble">${input}</div>
                </div>
            `);
            $('#chatInput').val('');
            $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);

            // Tampilkan loading
            var loadingId = 'loading-' + Date.now();
            $('#chatBox').append(`
                <div class="chat-message ai" id="${loadingId}">
                    <div class="bubble skeleton-bubble">
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text short"></div>
                    </div>
                </div>
            `);
            $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);

            $.ajax({
                url: "{{ route('dashboard.chat') }}",
                type: "POST",
                data: { question: input },
                success: function(res) {
                    $('#' + loadingId).remove();
                    $('#chatBox').append(`
                        <div class="chat-message ai">
                            <div class="bubble">${res.answer}</div>
                        </div>
                    `);
                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                },
                error: function(err) {
                    $('#' + loadingId).remove();
                    let errMsg = "Terjadi kesalahan pada sistem AI.";
                    
                    let responseText = err.responseText || "";
                    if (err.responseJSON && err.responseJSON.answer) {
                        errMsg = err.responseJSON.answer;
                    } else if (err.responseJSON && err.responseJSON.error) {
                        let innerErr = err.responseJSON.error;
                        errMsg = typeof innerErr === 'string' ? innerErr : (innerErr.message || "Terjadi kesalahan");
                    } else if (responseText.includes('high demand') || err.status === 429 || err.status === 503) {
                        errMsg = "Maaf, sistem AI sedang mengalami lonjakan permintaan (high demand). Hal ini biasanya bersifat sementara. Silakan coba lagi beberapa saat lagi ya! ⏳";
                    }
                    
                    if (typeof errMsg === 'string' && (errMsg.toLowerCase().includes('high demand') || errMsg.toLowerCase().includes('quota'))) {
                        errMsg = "Maaf, server AI sedang sibuk atau mengalami lonjakan permintaan (High Demand). Silakan tunggu sebentar dan coba tanyakan lagi. ⏳";
                    }

                    $('#chatBox').append(`
                        <div class="chat-message ai">
                            <div class="bubble text-danger" style="background-color: #fef2f2; border-color: #fca5a5;">${errMsg}</div>
                        </div>
                    `);
                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                }
            });
        });

        // Region Filter Change Event
        $('#regionFilter').change(function() {
            if(!map) return;
            let region = $(this).val();
            
            // Menggunakan fitBounds dan flyTo dari Leaflet untuk animasi sehalus sutra
            if (region === 'world') {
                map.flyTo([20, 0], 2, { duration: 1.5 });
            } else if (region === 'asia') {
                map.flyToBounds([[10, 60], [50, 145]], { duration: 1.5 });
            } else if (region === 'asia_tenggara') {
                map.flyToBounds([[-11, 95], [20, 141]], { duration: 1.5 }); // Pas koordinat Nusantara
            } else if (region === 'asia_timur') {
                map.flyToBounds([[20, 100], [50, 150]], { duration: 1.5 });
            } else if (region === 'eropa') {
                map.flyToBounds([[35, -10], [70, 40]], { duration: 1.5 });
            } else if (region === 'amerika') {
                map.flyToBounds([[-55, -130], [70, -35]], { duration: 1.5 });
            } else if (region === 'afrika') {
                map.flyToBounds([[-35, -20], [35, 50]], { duration: 1.5 });
            } else if (region === 'oseania') {
                map.flyToBounds([[-45, 110], [-10, 180]], { duration: 1.5 });
            }
        });
        
        // Load maps on start
        drawRegionsMap();

        // Initialize Additional Charts
        initAdditionalCharts();
    });

    function initAdditionalCharts() {
        const topCountriesData = @json($topCountries);
        const totalByMonthData = @json($totalByMonth);

        // Bar Chart (Top 5 Countries)
        if(topCountriesData && topCountriesData.length > 0) {
            Highcharts.chart('barChart', {
                chart: { type: 'column', backgroundColor: 'transparent' },
                title: { text: null },
                xAxis: {
                    categories: topCountriesData.map(item => item.nama_negara),
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: { text: 'Jumlah Wisatawan' }
                },
                plotOptions: {
                    column: {
                        borderRadius: 4,
                        color: '#0f4a8a',
                        dataLabels: { enabled: true, format: '{y:,.0f}' }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:,.0f} wisman</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                series: [{ name: 'Wisatawan (Mei)', data: topCountriesData.map(item => parseInt(item.jumlah)) }],
                credits: { enabled: false }
            });
        }

        // Pie Chart (Monthly Proportion)
        if(totalByMonthData && totalByMonthData.length > 0) {
            Highcharts.chart('pieChart', {
                chart: { type: 'pie', backgroundColor: 'transparent' },
                title: { text: null },
                tooltip: { pointFormat: '{series.name}: <b>{point.y:,.0f} wisman ({point.percentage:.1f}%)</b>' },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        colors: ['#0f4a8a', '#1e3a8a', '#3b82f6', '#93c5fd', '#f59e0b'],
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Total Wisatawan',
                    colorByPoint: true,
                    data: totalByMonthData.map(item => ({ name: item.bulan, y: parseInt(item.total) }))
                }],
                credits: { enabled: false }
            });
        }
    }

    let map;
    let geojsonLayer;

    function drawRegionsMap() {
        if(!map) {
            var bounds = [
                [-90, -180], // South West
                [90, 180]    // North East
            ];
            map = L.map('geomap', { 
                zoomControl: false,
                maxBounds: bounds,
                maxBoundsViscosity: 1.0,
                minZoom: 2
            }).setView([20, 0], 2); // Matikan zoomControl default supaya tidak mengganggu
            L.control.zoom({ position: 'bottomleft' }).addTo(map); // Pindahkan ke kiri bawah

            // Base map dari CartoDB (warna bersih, corporat, lengkap dengan NAMA NEGARA!)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 20,
                noWrap: true
            }).addTo(map);
        }

        $.ajax({
            url: "{{ route('dashboard.geomap') }}",
            type: "GET",
            dataType: "json",
            success: function (resData) {
                if(resData.length === 0) {
                    return; // Biarkan base map kosong jika tidak ada data
                }

                // Siapkan data untuk lookup cepat
                let dataDict = {};
                resData.forEach(item => {
                    let name = item.meta.nama.toUpperCase().trim();
                    if(name === 'BRUNEI D' || name === 'BRUNEI') {
                        dataDict['BRUNEI'] = item;
                    } else if (name === 'PHILIPPINES') {
                        dataDict['PHILIPPINES'] = item;
                    } else {
                        dataDict[name] = item;
                    }
                });

                // Ambil file GeoJSON dunia yang sudah dilokalkan agar anti-blokir
                $.getJSON('/countries.geo.json', function(geoData) {
                    if(geojsonLayer) {
                        map.removeLayer(geojsonLayer);
                    }

                    geojsonLayer = L.geoJSON(geoData, {
                        pointToLayer: function (feature, latlng) {
                            return L.circleMarker(latlng, {
                                radius: 8
                            });
                        },
                        style: function(feature) {
                            let fName = feature.properties.name ? feature.properties.name.toUpperCase().trim() : '';
                            if (dataDict[fName]) {
                                return { fillColor: '#0f4a8a', weight: 1, opacity: 1, color: '#ffffff', fillOpacity: 0.8 };
                            } else {
                                // Negara tanpa data dibiarkan super transparan agar nama dari Base Map kelihatan jelas
                                return { fillColor: '#e2e8f0', weight: 1, opacity: 0, color: '#cbd5e1', fillOpacity: 0.0 };
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            let fName = feature.properties.name ? feature.properties.name.toUpperCase().trim() : '';
                            let d = dataDict[fName];
                            if (d) {
                                let meta = d.meta;
                                var flagUrl = 'https://flagcdn.com/24x18/' + d.kode_negara.toLowerCase() + '.png';
                                var selisihFormatted = Math.abs(meta.selisih).toLocaleString('id-ID');
                                var trendText = meta.selisih >= 0 ? '+Naik ' + selisihFormatted : '-Turun ' + selisihFormatted;
                                var trendColor = meta.selisih >= 0 ? '#10b981' : '#ef4444';
                                
                                let tooltipContent = `
                                    <div style="padding:10px; width:220px; white-space:normal; font-family:'Inter', sans-serif; background:#ffffff; border-radius:8px; box-shadow:0 10px 25px rgba(0,0,0,0.15); border:1px solid #e2e8f0;">
                                        <h6 style="margin:0 0 10px 0; color:#333; display:flex; align-items:center;">
                                            <img src="${flagUrl}" style="margin-right:8px; border:1px solid #e2e8f0; border-radius:2px;"> 
                                            ${meta.nama}
                                        </h6>
                                        <div style="font-size:13px; color:#475569; margin-bottom:4px;">
                                            <span>Bulan ini:</span> 
                                            <b style="color:#0f172a; float:right;">${meta.mei.toLocaleString('id-ID')}</b>
                                        </div>
                                        <div style="font-size:13px; color:#475569; margin-bottom:8px;">
                                            <span>Bulan sebelumnya:</span> 
                                            <b style="color:#0f172a; float:right;">${meta.april.toLocaleString('id-ID')}</b>
                                        </div>
                                        <hr style="margin:8px 0; border-top:1px dashed #cbd5e1;">
                                        <div style="font-size:13px; color:${trendColor}; font-weight:700; text-align:right;">
                                            ${trendText}
                                        </div>
                                    </div>
                                `;
                                
                                layer.bindTooltip(tooltipContent, { sticky: true, className: 'leaflet-tooltip-custom', direction: 'auto' });
                                
                                layer.on('mouseover', function(e) {
                                    this.setStyle({ fillColor: '#f59e0b', fillOpacity: 0.9 });
                                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                        this.bringToFront();
                                    }
                                });
                                layer.on('mouseout', function(e) {
                                    this.setStyle({ fillColor: '#0f4a8a', fillOpacity: 0.8 });
                                });
                            }
                        }
                    }).addTo(map);

                    // Terapkan filter saat ini jika ada
                    $('#regionFilter').trigger('change');
                });
            }
        });
    }

    // Handle window resize for geomap responsiveness
    $(window).resize(function() {
        if(map) {
            map.invalidateSize();
        }
    });
</script>
</body>
</html>
