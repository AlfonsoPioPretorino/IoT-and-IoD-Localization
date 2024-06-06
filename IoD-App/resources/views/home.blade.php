@extends('layouts.master')
@section('content')
<head>
    <title>Home</title>
</head>
    <div class="container text-center mb-5 mt-5 text-white">
        <h1 class="display-3">Drone Position Triangulation</h1>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xs-8">
                <div class="card mx-5 pt-3 o-bg-card" style="text-align: center;border-radius:1rem; box-shadow: 0 1rem 1rem 0 rgba(0, 0, 0, 0.771);">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <h1>Insert Coordinates</h1>
                            </div>
                        </div>
                        <form action="/session/add" method="POST">
                        @csrf
                        <div class="row mt-5 mb-3">
                            <div class="col">
                                <h4>Gateway 1</h4>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col"></div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Latitude</span>
                                    <input type="text" name="g1la" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mx-auto w-70">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Longitude</span>
                                    <input type="text" name="g1lo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        
                        <div class="row mt-5 mb-3">
                            <div class="col">
                                <h4>Gateway 2</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <div class="input-group mx-auto w-70">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Latitude</span>
                                    <input type="text" name="g2la" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mx-auto w-70">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Longitude</span>
                                    <input type="text" name="g2lo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>

                        <div class="row mt-5 mb-3">
                            <div class="col">
                                <h4>Gateway 3</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <div class="input-group mx-auto w-70">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Latitude</span>
                                    <input type="text" name="g3la" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mx-auto w-70">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Longitude</span>
                                    <input type="text" name="g3lo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                </div>
                            </div>
                            <div class="col"></div>
                            <div class="row mb-3 mt-3">
                                <div class="col">
                                    <button type="submit" name="sub" id="sub" class="btn o-btn-primary btn-lg mt-4">Submit Coordinates</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection