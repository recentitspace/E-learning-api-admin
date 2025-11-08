@extends('lms::installer.layout')
@section('content')
    <div class="installment-section">
        <div class="installment-wrap">
            <fieldset>
                <div class="alert alert-danger error-message"> </div>
                <form action="{{ route('license.verify') }}" method="POST" class="form">
                    @csrf
                    <div class="step-title mb-25">
                        <h3>Verify Licencse Code </h3>
                    </div>
                    <div class="enviroment-wrap">

                        <div class="form-input-area">
                            <div class="w-100">
                                <div class="form-inner">
                                    <label> Email </label>
                                    <input type="text" name="email">
                                </div>
                                <span class="text-danger error-text email_err"></span>
                            </div>
                            <div class="w-100">
                                <div class="form-inner">
                                    <label> License Code </label>
                                    <input type="text" name="license_code">
                                </div>
                                <span class="text-danger error-text license_code_err"></span>
                            </div>
                        </div>
                        <div class="step-btn-group">
                            <button type="button" class="environment-btn next-btn">Verify</button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
@endsection
