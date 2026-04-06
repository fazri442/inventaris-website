<!DOCTYPE html>
<html lang="en">

<head>
    <title>Peminjaman | Edit</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Meta -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
      <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
      <meta name="author" content="codedthemes" />
      <!-- Favicon icon -->
      <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset ('front/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="{{ asset('front/css/bootstrap/css/bootstrap.min.css') }}">
      <!-- waves.css -->
      <link rel="stylesheet" href="{{asset ('front/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
      <!-- themify icon -->
      <link rel="stylesheet" type="text/css" href="{{asset ('front/icon/themify-icons/themify-icons.css') }}">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="{{asset ('front/icon/font-awesome/css/font-awesome.min.css') }}">
      <!-- scrollbar.css -->
      <link rel="stylesheet" type="text/css" href="{{asset ('front/css/jquery.mCustomScrollbar.css') }}">
        <!-- am chart export.css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('front/css/style.css') }}">
  </head>

  <body>
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->
  <div id="pcoded" class="pcoded">
      <div class="pcoded-overlay-box"></div>
      <div class="pcoded-container navbar-wrapper">
        {{-- navbar   --}}
        @include('layouts.part.navbar')
        {{-- navbar --}}
            <div class="pcoded-main-container">
              <div class="pcoded-wrapper">
                {{-- sidiebar --}}
                  @include('layouts.part.sidebar')
                {{-- sidebar --}}
                  <div class="pcoded-content">
                      <!-- Page-header start -->
                      <div class="page-header">
                          <div class="page-block">
                              <div class="row align-items-center">
                                  <div class="col-md-8">
                                      <div class="page-header-title">
                                          <h5 class="m-b-10">Merubah Data</h5>
                                          <p class="m-b-0">Halaman Merubah Data</p>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <ul class="breadcrumb-title">
                                          <li class="breadcrumb-item">
                                              <a href="{{ route('home') }}"> <i class="fa fa-home"></i> </a>
                                          </li>
                                          <li class="breadcrumb-item"><a href="{{ route('peminjam.index') }}">Peminjam</a>
                                          </li>
                                          <li class="breadcrumb-item"><a href="#!">Rubah</a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>

                                        <div class="card-body">
    <form action="{{ route('peminjam.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any() || session('error'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @if (session('error'))
                        <li>{{ session('error') }}</li>
                    @endif
                </ul>
            </div>
        @endif

        <!-- Informasi Umum (sama seperti create) -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <select name="id_tim" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($tim as $t)
                            <option value="{{ $t->id }}" {{ old('id_tim', $peminjaman->id_tim) == $t->id ? 'selected' : '' }}>
                                {{ $t->nama_anggota_tim }} ({{ $t->lokasi_tim }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" required>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Sedang Dipinjam" {{ old('status', $peminjaman->status) == 'Sedang Dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                <option value="Sudah Dikembalikan" {{ old('status', $peminjaman->status) == 'Sudah Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
            </select>
        </div>

        <!-- Daftar Barang (Dynamic, prefill existing) -->
        <div class="form-group mt-4">
            <label>Daftar Tool yang Dipinjam</label>
            <button type="button" class="btn btn-sm btn-success" id="addRow">Tambah Tool</button>

            <div class="table-responsive mt-2">
                <table class="table table-bordered" id="toolTable">
                    <thead>
                        <tr>
                            <th>Nama Tool</th>
                            <th>Jumlah</th>
                            <th>Stok Tersedia</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($existingDetails as $index => $detail)
                        <tr>
                            <td>
                                <select name="tools[{{ $index }}][id_tool]" class="form-control tool-select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($datapusat as $data)
                                        <option value="{{ $data->id }}" data-stok="{{ $data->stok }}" {{ $detail['id_tool'] == $data->id ? 'selected' : '' }}>
                                            {{ $data->nama_tool }} (Stok: {{ $data->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="tools[{{ $index }}][jumlah]" class="form-control jumlah-input" value="{{ $detail['jumlah'] }}" min="1" required>
                            </td>
                            <td class="stok-display text-center">{{ $detail['stok'] }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger removeRow">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Peminjaman</button>
        <a href="{{ route('peminjam.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<!-- Script JS (salin dari create, tambah prefill stok saat load) -->
<script>
    let rowIndex = {{ count($existingDetails) }};

    // ... script addRow, removeRow, change tool-select sama seperti create ...

    // Saat load halaman, trigger change untuk tampilkan stok awal
    $(document).ready(function() {
        $('.tool-select').trigger('change');
    });
</script>


                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
    <div class="ie-warning">
        <h1>Warning!!</h1>
        <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
        <div class="iew-container">
            <ul class="iew-download">
                <li>
                    <a href="http://www.google.com/chrome/">
                        <img src="assets/images/browser/chrome.png" alt="Chrome">
                        <div>Chrome</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.mozilla.org/en-US/firefox/new/">
                        <img src="assets/images/browser/firefox.png" alt="Firefox">
                        <div>Firefox</div>
                    </a>
                </li>
                <li>
                    <a href="http://www.opera.com">
                        <img src="assets/images/browser/opera.png" alt="Opera">
                        <div>Opera</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.apple.com/safari/">
                        <img src="assets/images/browser/safari.png" alt="Safari">
                        <div>Safari</div>
                    </a>
                </li>
                <li>
                    <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                        <img src="assets/images/browser/ie.png" alt="">
                        <div>IE (9 & above)</div>
                    </a>
                </li>
            </ul>
        </div>
        <p>Sorry for the inconvenience!</p>
    </div>
    <![endif]-->
    <!-- Warning Section Ends -->
    
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset ('front/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('front/js/jquery-ui/jquery-ui.min.js') }} "></script>
    <script type="text/javascript" src="{{ asset ('front/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{asset ('front/js/bootstrap/js/bootstrap.min.js') }} "></script>
    <script type="text/javascript" src="{{asset ('front/pages/widget/excanvas.js') }} "></script>
    <!-- waves js -->
    <script src="{{ asset ('front/pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset ('front/js/jquery-slimscroll/jquery.slimscroll.js') }} "></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset ('front/js/modernizr/modernizr.js') }} "></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="{{ asset ('front/js/SmoothScroll.js') }}"></script>
    <script src="{{ asset('front/js/jquery.mCustomScrollbar.concat.min.js') }} "></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset ('front/js/chart.js/Chart.js') }}"></script>
    <!-- amchart js -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="{{ asset('front/pages/widget/amchart/gauge.js') }}"></script>
    <script src="{{ asset('front/pages/widget/amchart/serial.js') }}"></script>
    <script src="{{ asset('front/pages/widget/amchart/light.js') }}"></script>
    <script src="{{ asset('front/pages/widget/amchart/pie.min.js') }}"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <!-- menu js -->
    <script src="{{ asset('front/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('front/js/vertical-layout.min.js') }} "></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ asset ('front/pages/dashboard/custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('front/js/script.js') }} "></script>
</body>

</html>
