@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-10 py-10">

    <h2 class="text-3xl font-bold mb-8">Edit Committee Member</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-5 rounded-lg mb-6">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-xl overflow-hidden">

        <form action="{{ route('admin.committees.members.update', [$committee->id, $member->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full border border-gray-200">

                <!-- Member Name -->
                <tr class="border-b">
                    <td class="w-1/4 bg-gray-50 p-5 font-semibold text-lg">Member Name</td>
                    <td class="p-5">
                        <input type="text" name="member_name" value="{{ old('member_name', $member->member_name) }}"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter full name">
                    </td>
                </tr>

                <!-- Gender -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg">Gender</td>
                    <td class="p-5">
                        <select name="member_gender"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('member_gender', $member->member_gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('member_gender', $member->member_gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('member_gender', $member->member_gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </td>
                </tr>

                <!-- Member ID -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg">Member ID (Optional)</td>
                    <td class="p-5">
                        <input type="number" name="member_id" value="{{ old('member_id', $member->member_id) }}"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Optional system ID">
                    </td>
                </tr>

                <!-- Phone -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg">Phone</td>
                    <td class="p-5">
                        <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter phone number">
                    </td>
                </tr>

            </table>

            <div class="p-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 text-lg rounded-lg shadow">
                    Update Member
                </button>
            </div>

        </form>
    </div>
</div>
@endsection