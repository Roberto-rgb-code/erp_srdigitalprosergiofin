@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Nuevo Empleado</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('recursos_humanos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Número de Empleado <span class="text-danger">*</span></label>
                <input type="text" name="numero_empleado" value="{{ old('numero_empleado') }}" class="form-control @error('numero_empleado') is-invalid @enderror" required>
                @error('numero_empleado')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control @error('nombre') is-invalid @enderror" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Apellido <span class="text-danger">*</span></label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" class="form-control @error('apellido') is-invalid @enderror" required>
                @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Puesto <span class="text-danger">*</span></label>
                <input type="text" name="puesto" value="{{ old('puesto') }}" class="form-control @error('puesto') is-invalid @enderror" required>
                @error('puesto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>RFC</label>
                <input type="text" name="rfc" value="{{ old('rfc') }}" class="form-control @error('rfc') is-invalid @enderror">
                @error('rfc')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>CURP</label>
                <input type="text" name="curp" value="{{ old('curp') }}" class="form-control @error('curp') is-invalid @enderror">
                @error('curp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Fecha de Ingreso <span class="text-danger">*</span></label>
                <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" class="form-control @error('fecha_ingreso') is-invalid @enderror" required>
                @error('fecha_ingreso')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="Activo" @selected(old('status')=='Activo')>Activo</option>
                    <option value="Inactivo" @selected(old('status')=='Inactivo')>Inactivo</option>
                    <option value="Baja" @selected(old('status')=='Baja')>Baja</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label>Tipo de Empleado <span class="text-danger">*</span></label>
                <select name="tipo_empleado" class="form-select @error('tipo_empleado') is-invalid @enderror" required>
                    <option value="fijo" @selected(old('tipo_empleado')=='fijo')>Fijo</option>
                    <option value="freelance" @selected(old('tipo_empleado')=='freelance')>Freelance</option>
                </select>
                @error('tipo_empleado')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label>Tipo de Contrato <span class="text-danger">*</span></label>
                <select name="tipo_contrato" class="form-select @error('tipo_contrato') is-invalid @enderror" required>
                    <option value="temporal" @selected(old('tipo_contrato')=='temporal')>Temporal</option>
                    <option value="prueba" @selected(old('tipo_contrato')=='prueba')>Prueba</option>
                    <option value="indefinido" @selected(old('tipo_contrato')=='indefinido')>Indefinido</option>
                </select>
                @error('tipo_contrato')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Datos personales adicionales -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Edad</label>
                <input type="number" name="edad" min="0" value="{{ old('edad') }}" class="form-control @error('edad') is-invalid @enderror">
                @error('edad')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label>Sexo</label>
                <select name="sexo" class="form-select @error('sexo') is-invalid @enderror">
                    <option value="">Seleccione...</option>
                    <option value="M" @selected(old('sexo')=='M')>M</option>
                    <option value="F" @selected(old('sexo')=='F')>F</option>
                    <option value="Otro" @selected(old('sexo')=='Otro')>Otro</option>
                </select>
                @error('sexo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label>Tipo de Sangre</label>
                <input type="text" name="tipo_sangre" value="{{ old('tipo_sangre') }}" class="form-control @error('tipo_sangre') is-invalid @enderror">
                @error('tipo_sangre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="form-control @error('fecha_nacimiento') is-invalid @enderror">
                @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Datos de contacto -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control @error('telefono') is-invalid @enderror">
                @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Correo</label>
                <input type="email" name="correo" value="{{ old('correo') }}" class="form-control @error('correo') is-invalid @enderror">
                @error('correo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Dirección</label>
                <textarea name="domicilio" class="form-control @error('domicilio') is-invalid @enderror">{{ old('domicilio') }}</textarea>
                @error('domicilio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Contacto emergencia -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Contacto de Emergencia</label>
                <input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia') }}" class="form-control @error('contacto_emergencia') is-invalid @enderror">
                @error('contacto_emergencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Parentesco</label>
                <input type="text" name="parentesco" value="{{ old('parentesco') }}" class="form-control @error('parentesco') is-invalid @enderror">
                @error('parentesco')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Teléfono Beneficiario</label>
                <input type="text" name="telefono_beneficiario" value="{{ old('telefono_beneficiario') }}" class="form-control @error('telefono_beneficiario') is-invalid @enderror">
                @error('telefono_beneficiario')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Datos bancarios -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Cuenta Fiscal</label>
                <input type="text" name="cuenta_fiscal" value="{{ old('cuenta_fiscal') }}" class="form-control @error('cuenta_fiscal') is-invalid @enderror">
                @error('cuenta_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>CLABE Fiscal</label>
                <input type="text" name="clabe_fiscal" value="{{ old('clabe_fiscal') }}" class="form-control @error('clabe_fiscal') is-invalid @enderror">
                @error('clabe_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Banco Fiscal</label>
                <input type="text" name="banco_fiscal" value="{{ old('banco_fiscal') }}" class="form-control @error('banco_fiscal') is-invalid @enderror">
                @error('banco_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Cuenta No Fiscal</label>
                <input type="text" name="cuenta_no_fiscal" value="{{ old('cuenta_no_fiscal') }}" class="form-control @error('cuenta_no_fiscal') is-invalid @enderror">
                @error('cuenta_no_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>CLABE No Fiscal</label>
                <input type="text" name="clabe_no_fiscal" value="{{ old('clabe_no_fiscal') }}" class="form-control @error('clabe_no_fiscal') is-invalid @enderror">
                @error('clabe_no_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Banco No Fiscal</label>
                <input type="text" name="banco_no_fiscal" value="{{ old('banco_no_fiscal') }}" class="form-control @error('banco_no_fiscal') is-invalid @enderror">
                @error('banco_no_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Datos laborales -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Horario Laboral</label>
                <input type="text" name="horario" value="{{ old('horario') }}" class="form-control @error('horario') is-invalid @enderror">
                @error('horario')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Días Laborales</label>
                <input type="text" name="dias_laborales" value="{{ old('dias_laborales') }}" class="form-control @error('dias_laborales') is-invalid @enderror">
                @error('dias_laborales')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Seguridad social y salarios -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Número de Seguro Social</label>
                <input type="text" name="nss" value="{{ old('nss') }}" class="form-control @error('nss') is-invalid @enderror">
                @error('nss')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Salario Diario Fiscal</label>
                <input type="number" step="0.01" name="salario_diario_fiscal" value="{{ old('salario_diario_fiscal') }}" class="form-control @error('salario_diario_fiscal') is-invalid @enderror">
                @error('salario_diario_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Salario Diario No Fiscal</label>
                <input type="number" step="0.01" name="salario_diario_no_fiscal" value="{{ old('salario_diario_no_fiscal') }}" class="form-control @error('salario_diario_no_fiscal') is-invalid @enderror">
                @error('salario_diario_no_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Salario Mensual Fiscal</label>
                <input type="number" step="0.01" name="salario_mensual_fiscal" value="{{ old('salario_mensual_fiscal') }}" class="form-control @error('salario_mensual_fiscal') is-invalid @enderror">
                @error('salario_mensual_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Salario Mensual No Fiscal</label>
                <input type="number" step="0.01" name="salario_mensual_no_fiscal" value="{{ old('salario_mensual_no_fiscal') }}" class="form-control @error('salario_mensual_no_fiscal') is-invalid @enderror">
                @error('salario_mensual_no_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Justificantes -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Justificantes Incapacidad</label>
                <input type="file" name="justificantes_incapacidad" class="form-control @error('justificantes_incapacidad') is-invalid @enderror">
                @error('justificantes_incapacidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Notas internas -->
        <div class="mb-3">
            <label>Notas internas</label>
            <textarea name="notas" class="form-control @error('notas') is-invalid @enderror">{{ old('notas') }}</textarea>
            @error('notas')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('recursos_humanos.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection
