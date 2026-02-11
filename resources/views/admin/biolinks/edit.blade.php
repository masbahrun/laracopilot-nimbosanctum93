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
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Biolink Settings</h3>
                    </div>
                    <form action="{{ route('admin.biolinks.update', $biolink->id) }}" method="POST" id="biolinkForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label class="text-sm">Domain <span class="text-danger">*</span></label>
                                <input type="text" name="domain" value="{{ old('domain', $biolink->domain) }}" 
                                       class="form-control form-control-sm @error('domain') is-invalid @enderror" required>
                                @error('domain')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="text-sm">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title', $biolink->title) }}" 
                                       class="form-control form-control-sm @error('title') is-invalid @enderror" required>
                                @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="text-sm">Description</label>
                                <textarea name="description" rows="2" class="form-control form-control-sm">{{ old('description', $biolink->description) }}</textarea>
                            </div>
                            
                            <!-- Layout Selection -->
                            <div class="form-group">
                                <label class="text-sm">Layout</label>
                                <select name="layout" class="form-control form-control-sm" id="layoutSelect">
                                    @foreach(\App\Models\Biolink::getAvailableLayouts() as $key => $layout)
                                    <option value="{{ $key }}" {{ old('layout', $biolink->layout) === $key ? 'selected' : '' }}>
                                        {{ $layout['name'] }} - {{ $layout['description'] }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Choose your biolink page layout style</small>
                            </div>
                            
                            <!-- Theme Color -->
                            <div class="form-group">
                                <label class="text-sm">Theme Color</label>
                                <div class="input-group input-group-sm">
                                    <input type="color" name="theme_color" value="{{ old('theme_color', $biolink->theme_color ?? '#667eea') }}" 
                                           class="form-control form-control-sm" style="max-width: 60px;" id="themeColorInput">
                                    <input type="text" class="form-control form-control-sm" id="themeColorText" 
                                           value="{{ old('theme_color', $biolink->theme_color ?? '#667eea') }}" readonly>
                                </div>
                                <small class="form-text text-muted">Main theme color for your biolink page</small>
                            </div>
                            
                            <!-- Avatar Upload -->
                            <div class="form-group">
                                <label class="text-sm">Avatar</label>
                                <div class="text-center mb-2">
                                    <img src="{{ $biolink->avatar_url }}" id="avatarPreview" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                </div>
                                <input type="file" id="avatarInput" accept="image/*" class="form-control-file">
                                <small class="form-text text-muted">Auto-saves on upload</small>
                            </div>
                            
                            <!-- Banner Upload -->
                            <div class="form-group">
                                <label class="text-sm">Banner</label>
                                @if($biolink->banner_path)
                                <div class="text-center mb-2">
                                    <img src="{{ $biolink->banner_url }}" id="bannerPreview" class="img-thumbnail" style="max-width: 100%;">
                                </div>
                                @endif
                                <input type="file" id="bannerInput" accept="image/*" class="form-control-file">
                                <small class="form-text text-muted">Auto-saves on upload</small>
                            </div>
                            
                            <hr>
                            <h6 class="text-sm font-weight-bold">SEO Settings</h6>
                            
                            <div class="form-group">
                                <label class="text-sm">SEO Title</label>
                                <input type="text" name="seo_title" value="{{ old('seo_title', $biolink->seo_title) }}" class="form-control form-control-sm">
                            </div>
                            
                            <div class="form-group">
                                <label class="text-sm">SEO Description</label>
                                <textarea name="seo_description" rows="2" class="form-control form-control-sm">{{ old('seo_description', $biolink->seo_description) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="text-sm">SEO Keywords</label>
                                <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $biolink->seo_keywords) }}" class="form-control form-control-sm">
                            </div>
                            
                            <div class="form-group">
                                <label class="text-sm">Custom Meta Tags</label>
                                <textarea name="custom_metatags" rows="2" class="form-control form-control-sm" placeholder="<meta name='author' content='Your Name'>">{{ old('custom_metatags', $biolink->custom_metatags) }}</textarea>
                            </div>
                            
                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="active" name="active" {{ old('active', $biolink->active) ? 'checked' : '' }}>
                                    <label class="custom-control-label text-sm" for="active">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-save"></i> Update Settings
                            </button>
                            <a href="{{ route('admin.biolinks.preview', $biolink->id) }}" target="_blank" class="btn btn-info btn-sm btn-block mt-2">
                                <i class="fas fa-eye"></i> Preview Biolink
                            </a>
                            <a href="{{ url('/ampproject/' . $biolink->domain) }}" target="_blank" class="btn btn-warning btn-sm btn-block mt-2">
                                <i class="fas fa-bolt"></i> View AMP Version
                            </a>
                            <a href="http://{{ $biolink->domain }}" target="_blank" class="btn btn-success btn-sm btn-block mt-2">
                                <i class="fas fa-external-link-alt"></i> Visit Live Page
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Right Column: Bio Items -->
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Bio Items</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" id="expandAllBtn" title="Expand All">
                                <i class="fas fa-expand-alt"></i>
                            </button>
                            <button type="button" class="btn btn-tool" id="collapseAllBtn" title="Collapse All">
                                <i class="fas fa-compress-alt"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addItemModal">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="bioItemsContainer" class="sortable-list">
                            @forelse($biolink->bioItems as $item)
                            <div class="card mb-2" data-item-id="{{ $item->id }}">
                                <div class="card-header py-2" style="cursor: move; background-color: #f8f9fa;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1" data-toggle="collapse" data-target="#item{{ $item->id }}" style="cursor: pointer;">
                                            <i class="fas fa-grip-vertical mr-2 text-muted"></i>
                                            <span class="badge badge-{{ $item->type === 'bio' ? 'info' : ($item->type === 'link' ? 'primary' : ($item->type === 'image' ? 'success' : 'secondary')) }}">{{ ucfirst($item->type) }}</span>
                                            <strong class="ml-2">{{ $item->title ?? 'Untitled' }}</strong>
                                            <i class="fas fa-chevron-down ml-2 text-muted"></i>
                                        </div>
                                        <div>
                                            <span class="badge badge-{{ $item->active ? 'success' : 'secondary' }} mr-2">{{ $item->active ? 'Active' : 'Inactive' }}</span>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="deleteBioItem({{ $item->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="item{{ $item->id }}" class="collapse">
                                    <div class="card-body py-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control form-control-sm mb-2 item-title" data-item-id="{{ $item->id }}" 
                                                       placeholder="Title" value="{{ $item->title }}">
                                                
                                                @if($item->type === 'bio' || $item->type === 'text')
                                                <textarea class="form-control form-control-sm mb-2 item-content" data-item-id="{{ $item->id }}" 
                                                          rows="2" placeholder="Content">{{ $item->content }}</textarea>
                                                @endif
                                                
                                                @if($item->type === 'link' || $item->type === 'image')
                                                <input type="url" class="form-control form-control-sm mb-2 item-url" data-item-id="{{ $item->id }}" 
                                                       placeholder="URL" value="{{ $item->url }}">
                                                @endif
                                                
                                                @if($item->type === 'link')
                                                <div class="d-flex align-items-center mb-2">
                                                    <label class="text-sm mb-0 mr-2">Icon:</label>
                                                    <input type="file" class="form-control-file form-control-sm item-icon" data-item-id="{{ $item->id }}" accept="image/*">
                                                    @if($item->icon_path)
                                                    <img src="{{ $item->icon_url }}" class="ml-3" style="max-width: 30px; max-height: 30px;">
                                                    @endif
                                                </div>
                                                @endif
                                                
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input item-active" id="active{{ $item->id }}" 
                                                           data-item-id="{{ $item->id }}" {{ $item->active ? 'checked' : '' }}>
                                                    <label class="custom-control-label text-sm" for="active{{ $item->id }}">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>No items yet. Click "Add Item" to start.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Item Type</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <button type="button" class="btn btn-outline-info btn-block py-4" onclick="addBioItem('bio')" data-dismiss="modal">
                            <i class="fas fa-user fa-2x d-block mb-2"></i>
                            <strong>Bio</strong>
                            <small class="d-block text-muted">About section</small>
                        </button>
                    </div>
                    <div class="col-6 mb-3">
                        <button type="button" class="btn btn-outline-primary btn-block py-4" onclick="addBioItem('link')" data-dismiss="modal">
                            <i class="fas fa-link fa-2x d-block mb-2"></i>
                            <strong>Link</strong>
                            <small class="d-block text-muted">External URL</small>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-success btn-block py-4" onclick="addBioItem('image')" data-dismiss="modal">
                            <i class="fas fa-image fa-2x d-block mb-2"></i>
                            <strong>Image</strong>
                            <small class="d-block text-muted">Image with URL</small>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-secondary btn-block py-4" onclick="addBioItem('text')" data-dismiss="modal">
                            <i class="fas fa-paragraph fa-2x d-block mb-2"></i>
                            <strong>Text</strong>
                            <small class="d-block text-muted">Plain text block</small>
                        </button>
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

// Theme color sync
$('#themeColorInput').on('input', function() {
    $('#themeColorText').val($(this).val());
});

// Expand/Collapse all buttons
$('#expandAllBtn').click(function() {
    $('.collapse').collapse('show');
});

$('#collapseAllBtn').click(function() {
    $('.collapse').collapse('hide');
});

// Toggle chevron icon on collapse
$('.collapse').on('show.bs.collapse', function() {
    $(this).prev().find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
});

$('.collapse').on('hide.bs.collapse', function() {
    $(this).prev().find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
});

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
$(document).on('input change', '.item-title, .item-content, .item-url, .item-active', function() {
    const itemId = $(this).data('item-id');
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => saveItem(itemId), 1000);
});

function saveItem(itemId) {
    const card = $(`[data-item-id="${itemId}"]`);
    const type = card.find('.badge').first().text().trim().toLowerCase();
    const data = {
        type: type,
        title: card.find('.item-title').val(),
        content: card.find('.item-content').val() || '',
        url: card.find('.item-url').val() || '',
        active: card.find('.item-active').is(':checked')
    };
    
    $.ajax({
        url: `/admin/biolinks/${biolinkId}/items/${itemId}`,
        method: 'PUT',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: data,
        success: function() {
            const statusBadge = card.find('.card-header .badge-success, .card-header .badge-secondary').last();
            if (data.active) {
                statusBadge.removeClass('badge-secondary').addClass('badge-success').text('Active');
            } else {
                statusBadge.removeClass('badge-success').addClass('badge-secondary').text('Inactive');
            }
            console.log('Item saved');
        }
    });
}

function addBioItem(type) {
    $.ajax({
        url: `/admin/biolinks/${biolinkId}/items`,
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: {type: type, title: 'New ' + type.charAt(0).toUpperCase() + type.slice(1)},
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
