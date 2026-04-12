@extends('layouts.district_admin')

@section('content')

<h2>Create Pastoral Transfer</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('district.admin.pastoral.transfers.store') }}">
    @csrf

    <!-- ================= PASTOR ================= -->
    <label>Pastor</label>
    <select name="pastoral_team_id" id="pastor" required>
        <option value="">Select Pastor</option>
        @foreach($pastors as $pastor)
            <option 
                value="{{ $pastor->id }}"
                data-district="{{ $pastor->district_id }}"
                data-assembly="{{ $pastor->assembly_id }}"
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
        <option value="within">Within District</option>
        <option value="outside">To Another District</option>
    </select>

    <hr>

    <!-- ================= FROM (AUTO FILLED) ================= -->
    <input type="hidden" name="from_district_id" id="from_district">
    <input type="hidden" name="from_assembly_id" id="from_assembly">

    <p><strong>From District:</strong> <span id="from_district_text">-</span></p>
    <p><strong>From Assembly:</strong> <span id="from_assembly_text">-</span></p>

    <hr>

    <!-- ================= TARGET DISTRICT ================= -->
    <div id="district_box" style="display:none;">
        <label>Target District</label>
        <select name="to_district_id" id="to_district">
            <option value="">Select District</option>
            @foreach($districts as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
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
    <textarea name="reason"></textarea>

    <br><br>

    <button type="submit" style="background:blue;color:white;padding:10px;">
        Submit Transfer
    </button>
</form>

@endsection

{{-- ================= SCRIPT ================= --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    let fromDistrict = null;

    // ================= PASTOR SELECT =================
    $('#pastor').on('change', function(){

        let district = $(this).find(':selected').data('district');
        let assembly = $(this).find(':selected').data('assembly');

        fromDistrict = district;

        $('#from_district').val(district);
        $('#from_assembly').val(assembly);

        $('#from_district_text').text(district);
        $('#from_assembly_text').text(assembly);

    });

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
                options += `<option value="${item.id}">${item.name}</option>`;
            });

            $(target).html(options);

        });
    }

});
</script>