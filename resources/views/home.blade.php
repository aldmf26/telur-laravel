@extends('layouts.app')

@section('content')
    <section class="section">
        {{-- <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div> --}}
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                          @role('admin')
                          <h1>tes</h1>
                          @endrole
                            <h4>Pengiriman Ayam</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
                                        <th>Bawa</th>
                                        <th>Ekor</th>
                                        <th>Admin</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                              
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Dashboard Content</h3>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
@endsection
