@csrf
<label>Name</label>
<input type="text" name="name" value="{{ old('name', $department->name ?? '') }}" required>

<label>Overview</label>
<textarea name="overview">{{ old('overview', $department->overview ?? '') }}</textarea>

<label>Leadership</label>
<textarea name="leadership">{{ old('leadership', $department->leadership ?? '') }}</textarea>

<label>Activities</label>
<textarea name="activities">{{ old('activities', $department->activities ?? '') }}</textarea>

<label>Document (PDF/DOC)</label>
<input type="file" name="document_path">

<label>Description</label>
<textarea name="description">{{ old('description', $department->description ?? '') }}</textarea>

<button type="submit" style="background:#9C27B0; color:#fff; padding:8px 16px; border-radius:6px; margin-top:10px;">
    {{ $buttonText }}
</button>
