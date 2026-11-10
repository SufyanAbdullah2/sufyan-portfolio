<div class="admin-field-grid">
    <div class="admin-field"><label for="title">PROJECT NAME</label><input id="title" name="title" value="{{ old('title', $project->title) }}" required maxlength="255">@error('title')<small class="admin-error">{{ $message }}</small>@enderror</div>
    <div class="admin-field"><label for="category">CATEGORY</label><input id="category" name="category" value="{{ old('category', $project->category) }}" required maxlength="80" placeholder="e.g. DIGITAL EXPERIENCE">@error('category')<small class="admin-error">{{ $message }}</small>@enderror</div>
</div>
<div class="admin-field"><label for="description">A SHORT STORY ABOUT IT</label><textarea id="description" name="description" rows="4" required maxlength="5000">{{ old('description', $project->description) }}</textarea>@error('description')<small class="admin-error">{{ $message }}</small>@enderror</div>
<div class="admin-field-grid">
    <div class="admin-field"><label for="image_url">PREVIEW IMAGE PATH OR URL</label><input id="image_url" name="image_url" value="{{ old('image_url', $project->image_url) }}" maxlength="2048" placeholder="/images/projects/my-project.jpg">@error('image_url')<small class="admin-error">{{ $message }}</small>@enderror</div>
    <div class="admin-field"><label for="project_url">LIVE PROJECT LINK</label><input id="project_url" type="url" name="project_url" value="{{ old('project_url', $project->project_url) }}" maxlength="2048" placeholder="https://...">@error('project_url')<small class="admin-error">{{ $message }}</small>@enderror</div>
</div>
<div class="admin-field-grid admin-field-grid-small">
    <div class="admin-field"><label for="year">YEAR</label><input id="year" name="year" value="{{ old('year', $project->year) }}" inputmode="numeric" maxlength="4" placeholder="{{ now()->year }}">@error('year')<small class="admin-error">{{ $message }}</small>@enderror</div>
    <div class="admin-field"><label for="sort_order">DISPLAY ORDER</label><input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0" required>@error('sort_order')<small class="admin-error">{{ $message }}</small>@enderror</div>
</div>
<label class="admin-checkbox"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published ?? true))> Show this project on my portfolio</label>
<div class="admin-form-actions"><a class="admin-text-link" href="{{ route('admin.projects.index') }}">CANCEL</a><button class="admin-button" type="submit">SAVE PROJECT <span>↗</span></button></div>
