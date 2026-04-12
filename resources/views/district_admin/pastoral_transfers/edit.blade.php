@extends('layouts.district_admin')

@section('content')

<h2>Edit Pastoral Transfer</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('district.admin.pastoral.transfers.update', $transfer->id) }}">
    @csrf
    @method('PUT')

    <!-- ================= PASTOR ================= -->
    <label>Pastor</label>
    <select name="pastoral_team_id" id="pastor" required>
        <option value="">Select Pastor</option>
        @foreach($pastors as $pastor)
            <option 
                value="{{ $pastor->id }}"
                data-district="{{ $pastor->district_id }}"
                data-assembly="{{ $pastor->assembly_id }}"
                {{ $transfer->pastoral_team_id == $pastor->id ? 'selected' : '' }}
            >
                {{ $pastor->name }}
            </option>
        @endforeach
    </select>

    <hr>

    <!-- ================= TRANSFER TYPE ================= -->
    <label>Transfer Type</label>
    <select name="transfer_type" id="transfer_type" required>
        <option value="">Select Type</option>
        <option value="within" {{ $transfer->from_district_id == $transfer->to_district_id ? 'selected' : '' }}>
            Within District
        </option>
        <option value="outside" {{ $transfer->from_district_id != $transfer->to_district_id ? 'selected' : '' }}>
            To Another District
        </option>
    </select>

    <hr>

    <!-- ================= FROM (AUTO FILLED) ================= -->
    <input type="hidden" name="from_district_id" id="from_district" value="{{ $transfer->from_district_id }}">
    <input type="hidden" name="from_assembly_id" id="from_assembly" value="{{ $transfer->from_assembly_id }}">

    <p><strong>From District:</strong> <span id="from_district_text">{{ $transfer->fromDistrict->name ?? '' }}</span></p>
    <p><strong>From Assembly:</strong> <span id="from_assembly_text">{{ $transfer->fromAssembly->name ?? '' }}</span></p>

    <hr>

    <!-- ================= TARGET DISTRICT ================= -->
    <div id="district_box" style="{{ $transfer->from_district_id == $transfer->to_district_id ? 'display:none;' : '' }}">
        <label>Target District</label>
        <select name="to_district_id" id="to_district">
            <option value="">Select District</option>
            @foreach($districts as $d)
                <option value="{{ $d->id }}" {{ $transfer->to_district_id == $d->id ? 'selected' : '' }}>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <!-- ================= TARGET ASSEMBLY ================= -->
    <label>Target Assembly</label>
    <select name="to_assembly_id" id="to_assembly" required>
        <option value="">Select Assembly</option>
    </select>

    <hr>

    <!-- ================= REASON ================= -->
    <label>Reason</label>
    <textarea name="reason">{{ $transfer->reason }}</textarea>

    <br><br>

    <button type="submit" style="background:blue;color:white;padding:10px;">
        Update Transfer
    </button>

    <a href="{{ route('district.admin.pastoral.transfers.index') }}" style="margin-left:10px;">
        Cancel
    </a>
</form>

@endsection

{{-- ================= SCRIPT ================= --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    let fromDistrict = $('#from_district').val();

    // ================= INIT PASTOR =================
    let selected = $('#pastor').find(':selected');
    if(selected.length) {
        $('#from_district_text').text(selected.data('district'));
        $('#from_assembly_text').text(selected.data('assembly'));
    }

    // ================= TRANSFER TYPE =================
    $('#transfer_type').on('change', function(){

        let type = $(this).val();

        if(type === 'within') {
            $('#district_box').hide();
            $('#to_district').val(fromDistrict);
            loadAssemblies(fromDistrict, '#to_assembly');
        } 
        else if(type === 'outside') {
            $('#district_box').show();
            $('#to_assembly').html('<option>Select District First</option>');
        }

    });

    // ================= TARGET DISTRICT =================
    $('#to_district').on('change', function(){
        loadAssemblies($(this).val(), '#to_assembly');
    });

    // ================= LOAD ASSEMBLIES =================
    function loadAssemblies(district_id, target){

        if(!district_id) return;

        $(target).html('<option>Loading...</option>');

        $.get('/district-admin/get-assemblies/' + district_id, function(data){

            let options = '<option value="">Select Assembly</option>';

            data.forEach(function(item){
                options += `<option value="${item.id}" ${item.id == "{{ $transfer->to_assembly_id }}" ? 'selected' : ''}>${item.name}</option>`;
            });

            $(target).html(options);
        });
    }

    // AUTO LOAD ON PAGE OPEN
    let initialDistrict = $('#to_district').val() || fromDistrict;
    if(initialDistrict){
        loadAssemblies(initialDistrict, '#to_assembly');
    }

});
</script>