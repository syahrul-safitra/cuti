<!-- Sidebar navigation-->
<nav class="sidebar-nav">
    <ul id="sidebarnav" class="p-t-30">
        {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/') }}"
                aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
        </li> --}}

        @if (Auth::guard('admin')->check())
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ url('dashboard/datapegawai') }}" aria-expanded="false"><i
                        class="mdi mdi-view-dashboard"></i><span class="hide-menu">Data
                        Pegawai</span></a>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ url('dashboard/dataatasan') }}" aria-expanded="false"><i
                        class="mdi mdi-view-dashboard"></i><span class="hide-menu">Data
                        Atasan</span></a>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ url('dashboard/surat') }}" aria-expanded="false"><i
                        class="mdi mdi-view-dashboard"></i><span class="hide-menu">Data
                        Surat</span></a>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ url('dashboard/lihatpengajuancuti') }}" aria-expanded="false"><i
                        class="mdi mdi-view-dashboard"></i><span class="hide-menu">Data Pengajuan Cuti</span></a>
            </li>
        @endif

        @if (Auth::guard('pegawai')->check())
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ url('dashboard/pengajuancuti') }}" aria-expanded="false"><i
                        class="mdi mdi-view-dashboard"></i><span class="hide-menu">Ajukan Cuti</span></a>
            </li>
            {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                href="{{ url('dashboard/riwayatcuti') }}" aria-expanded="false"><i
                    class="mdi mdi-view-dashboard"></i><span class="hide-menu">Riwayat Pengajuan Cuti</span></a>
        </li> --}}
        @endif

        @if (Auth::guard('atasan')->check())

            @if (Auth::guard('atasan')->user()->nama_kelompok == 'KTU')
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('dahsboard/persetujuankedua') }}" aria-expanded="false"><i
                            class="mdi mdi-view-dashboard"></i><span class="hide-menu">Pengajuan Cuti</span></a>
                </li>
            @else
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('dashboard/persetujuanpertama') }}" aria-expanded="false"><i
                            class="mdi mdi-view-dashboard"></i><span class="hide-menu">Pengajuan Cuti </span></a>
                </li>

                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('dashboard/persetujuanpertama2') }}" aria-expanded="false"><i
                            class="mdi mdi-view-dashboard"></i><span class="hide-menu">Pengajuan sudah </span></a>
                </li> --}}
            @endif
        @endif
    </ul>
</nav>
<!-- End Sidebar navigation -->
