@extends('layouts.admin')

@section('content')

<div style="max-width:750px; margin:40px auto; padding:30px; background:#fff; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.12);">

    <h2 style="text-align:center; color:#1e3c72; margin-bottom:30px;">
        Create District Admin
    </h2>

    <form method="POST" action="{{ route('admin.district_admins.store') }}">
        @csrf

        <!-- ================= DISTRICT ================= -->
        <div style="margin-bottom:25px;">
            <label style="font-weight:bold;">Select District</label>

            <select id="district_id"
                    name="district_id"
                    required
                    style="width:100%; padding:12px; border-radius:6px; border:1px solid #ccc;">
                <option value="">-- Select District --</option>
                @foreach($districts as $district)
                    <option value="{{ $district->id }}">
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- ================= USERNAME PREVIEW (NEW) ================= -->
        <div style="margin-bottom:25px;">
            <label style="font-weight:bold;">Generated Username</label>

            <input type="text"
                   id="username_preview"
                   readonly
                   placeholder="Will appear after selecting district"
                   style="width:100%; padding:12px; border-radius:6px; border:1px solid #ccc; background:#f5f5f5;">
        </div>

        <!-- ================= SECRETARY ================= -->
        <div style="margin-bottom:25px;">
            <label style="font-weight:bold;">Secretary (Only Secretaries)</label>

            <select id="leader_id"
                    name="leader_id"
                    required
                    style="width:100%; padding:12px; border-radius:6px; border:1px solid #ccc;">
                <option value="">Select District First</option>
            </select>
        </div>

        <!-- ================= PASSWORD ================= -->
        <div style="margin-bottom:30px;">
            <label style="font-weight:bold;">Password</label>

            <input type="password"
                   name="password"
                   required
                   style="width:100%; padding:12px; border-radius:6px; border:1px solid #ccc;">
        </div>

        <button type="submit"
                style="width:100%; padding:14px; background:#4CAF50; color:#fff; border:none; border-radius:6px; font-size:16px;">
            Create District Admin
        </button>

    </form>

</div>

@endsection


{{-- ================= JAVASCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const district = document.getElementById('district_id');
    const secretary = document.getElementById('leader_id');
    const usernamePreview = document.getElementById('username_preview');

    district.addEventListener('change', function () {

        let id = this.value;
        let districtName = this.options[this.selectedIndex].text;

        // ================= USERNAME PREVIEW =================
        if (!id) {
            usernamePreview.value = '';
        } else {
            let prefix = "PAG";
            let clean = districtName.replace(/[^A-Za-z]/g, '').toUpperCase().substring(0,2);

            // NOTE: backend controls real numbering
            usernamePreview.value = prefix + clean + "001";
        }

        // ================= SECRETARY LOAD =================
        secretary.innerHTML = '<option>Loading...</option>';

        if (!id) {
            secretary.innerHTML = '<option>Select District First</option>';
            return;
        }

        fetch('/admin/district-admins/secretaries/' + id)
            .then(res => res.json())
            .then(data => {

                secretary.innerHTML = '';

                if (data.length === 0) {
                    secretary.innerHTML = '<option>No Secretary Found</option>';
                    return;
                }

                secretary.innerHTML = '<option value="">-- Select Secretary --</option>';

                data.forEach(sec => {
                    let option = document.createElement('option');
                    option.value = sec.id;
                    option.textContent = sec.name;
                    secretary.appendChild(option);
                });

            })
            .catch(err => {
                console.error(err);
                secretary.innerHTML = '<option>Error loading secretary</option>';
            });
    });

});
</script>