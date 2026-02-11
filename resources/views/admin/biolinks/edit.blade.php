@extends('layouts.admin')

@section('title', 'Edit Biolink')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Biolink: {{ $biolink->title }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
        @endif
        
        <div class="row">
            <!-- Left Column: Biolink Settings -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Biolink Settings</h3>
                    </div>
                    <form action="{{ route('admin.biolinks.update', $biolink->id) }}" method="POST" id="biolinkForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Domain <span class="text-danger">*</span></label>
                                <input type="text" name="domain" value="{{ old('domain', $biolink->domain) }}" 
                                       class="form-control @error('domain') is-invalid @enderror" required>
                                @error('domain')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title', $biolink->title) }}" 
                                       class="form-control @error('title') is-invalid @enderror" required>
                                @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="3" class="form-control">{{ old('description', $biolink->description) }}</textarea>
                            </div>
                            
                            <!-- Avatar Upload -->
                            <div class="form-group">
                                <label>Avatar</label>
                                <div class="text-center mb-2">
                                    <img src="{{ $biolink->avatar_url }}" id="avatarPreview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                </div>
                                <input type="file" id="avatarInput" accept="image/*" class="form-control-file">
                                <small class="form-text text-muted">Click to upload new avatar (auto-saves)</small>
                            </div>
                            
                            <!-- Banner Upload -->
                            <div class="form-group">
                                <label>Banner</label>
                                @if($biolink->banner_path)
                                <div class="text-center mb-2">
                                    <img src="{{ $biolink->banner_url }}" id="bannerPreview" class="img-thumbnail" style="max-width: 100%;">
                                </div>
                                @endif
                                <input type="file" id="bannerInput" accept="image/*" class="form-control-file">
                                <small class="form-text text-muted">Click to upload new banner (auto-saves)</small>
                            </div>
                            
                            <hr>
                            <h6>SEO Settings</h6>
                            
                            <div class="form-group">
                                <label>SEO Title</label>
                                <input type="text" name="seo_title" value="{{ old('seo_title', $biolink->seo_title) }}" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>SEO Description</label>
                                <textarea name="seo_description" rows="2" class="form-control">{{ old('seo_description', $biolink->seo_description) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>SEO Keywords</label>
                                <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $biolink->seo_keywords) }}" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Custom Meta Tags</label>
                                <textarea name="custom_metatags" rows="3" class="form-control">{{ old('custom_metatags', $biolink->custom_metatags) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="active" name="active" {{ old('active', $biolink->active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Update Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Right Column: Bio Items -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bio Items</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" onclick="addBioItem()">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="bioItemsContainer" class="sortable-list">
                            @foreach($biolink->bioItems as $item)
                            <div class="card mb-3" data-item-id="{{ $item->id }}">
                                <div class="card-header" style="cursor: move;">
                                    <i class="fas fa-grip-vertical mr-2"></i>
                                    <strong>{{ ucfirst($item->type) }}</strong>: {{ $item->title ?? 'Untitled' }}
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteBioItem({{ $item->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-control item-type" data-item-id="{{ $item->id }}">
                                                <option value="bio" {{ $item->type === 'bio' ? 'selected' : '' }}>Bio</option>
                                                <option value="link" {{ $item->type === 'link' ? 'selected' : '' }}>Link</option>
                                                <option value="image" {{ $item->type === 'image' ? 'selected' : '' }}>Image</option>
                                                <option value="text" {{ $item->type === 'text' ? 'selected' : '' }}>Text</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control mb-2 item-title" data-item-id="{{ $item->id }}" 
                                                   placeholder="Title" value="{{ $item->title }}">
                                            <textarea class="form-control mb-2 item-content" data-item-id="{{ $item->id }}" 
                                                      rows="2" placeholder="Content">{{ $item->content }}</textarea>
                                            <input type="url" class="form-control mb-2 item-url" data-item-id="{{ $item->id }}" 
                                                   placeholder="URL" value="{{ $item->url }}">
                                            <div class="d-flex align-items-center">
                                                <input type="file" class="form-control-file item-icon" data-item-id="{{ $item->id }}" accept="image/*">
                                                @if($item->icon_path)
                                                <img src="{{ $item->icon_url }}" class="ml-3" style="max-width: 40px; max-height: 40px;">
                                                @endif
                                            </div>
                                            <div class="custom-control custom-switch mt-2">
                                                <input type="checkbox" class="custom-control-input item-active" id="active{{ $item->id }}" 
                                                       data-item-id="{{ $item->id }}" {{ $item->active ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="active{{ $item->id }}">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
const biolinkId = {{ $biolink->id }};
let saveTimeout;

// Sortable drag-drop
$('#bioItemsContainer').sortable({
    handle: '.card-header',
    update: function() {
        const items = [];
        $('.card[data-item-id]').each(function() {
            items.push($(this).data('item-id'));
        });
        
        $.ajax({
            url: `/admin/biolinks/${biolinkId}/items/reorder`,
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            data: {items: items},
            success: function() {
                console.log('Order updated');
            }
        });
    }
});

// Autosave on input change
$(document).on('input change', '.item-type, .item-title, .item-content, .item-url, .item-active', function() {
    const itemId = $(this).data('item-id');
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => saveItem(itemId), 1000);
});

function saveItem(itemId) {
    const card = $(`[data-item-id="${itemId}"]`);
    const data = {
        type: card.find('.item-type').val(),
        title: card.find('.item-title').val(),
        content: card.find('.item-content').val(),
        url: card.find('.item-url').val(),
        active: card.find('.item-active').is(':checked')
    };
    
    $.ajax({
        url: `/admin/biolinks/${biolinkId}/items/${itemId}`,
        method: 'PUT',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: data,
        success: function() {
            console.log('Item saved');
        }
    });
}

function addBioItem() {
    $.ajax({
        url: `/admin/biolinks/${biolinkId}/items`,
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: {type: 'link', title: 'New Item', active: true},
        success: function(response) {
            location.reload();
        }
    });
}

function deleteBioItem(itemId) {
    if (!confirm('Delete this item?')) return;
    
    $.ajax({
        url: `/admin/biolinks/${biolinkId}/items/${itemId}`,
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        success: function() {
            $(`[data-item-id="${itemId}"]`).remove();
        }
    });
}

// Avatar upload
$('#avatarInput').change(function() {
    const formData = new FormData();
    formData.append('avatar', this.files[0]);
    
    $.ajax({
        url: `/admin/biolinks/${biolinkId}/upload-avatar`,
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#avatarPreview').attr('src', response.avatar_url);
        }
    });
});

// Banner upload
$('#bannerInput').change(function() {
    const formData = new FormData();
    formData.append('banner', this.files[0]);
    
    $.ajax({
        url: `/admin/biolinks/${biolinkId}/upload-banner`,
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#bannerPreview').attr('src', response.banner_url);
        }
    });
});

// Icon upload
$(document).on('change', '.item-icon', function() {
    const itemId = $(this).data('item-id');
    const formData = new FormData();
    formData.append('icon', this.files[0]);
    
    $.ajax({
        url: `/admin/bioitems/${itemId}/upload-icon`,
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            location.reload();
        }
    });
});
</script>
@endsection
