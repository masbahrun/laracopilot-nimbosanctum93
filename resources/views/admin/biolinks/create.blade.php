@extends('layouts.admin')

@section('title', 'Create Biolink')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create New Biolink</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form action="{{ route('admin.biolinks.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Domain <span class="text-danger">*</span></label>
                                <input type="text" name="domain" value="{{ old('domain') }}" 
                                       class="form-control @error('domain') is-invalid @enderror" 
                                       placeholder="example.bio" required>
                                @error('domain')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Enter the full domain (e.g., yourdomain.bio)</small>
                            </div>
                            
                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Your Name - Your Title" required>
                                @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="3" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Brief description about yourself or business">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <hr>
                            <h5>SEO Settings</h5>
                            
                            <div class="form-group">
                                <label>SEO Title</label>
                                <input type="text" name="seo_title" value="{{ old('seo_title') }}" 
                                       class="form-control @error('seo_title') is-invalid @enderror" 
                                       placeholder="Title for search engines (50-60 characters)">
                                @error('seo_title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>SEO Description</label>
                                <textarea name="seo_description" rows="2" 
                                          class="form-control @error('seo_description') is-invalid @enderror" 
                                          placeholder="Description for search engines (150-160 characters)">{{ old('seo_description') }}</textarea>
                                @error('seo_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>SEO Keywords</label>
                                <input type="text" name="seo_keywords" value="{{ old('seo_keywords') }}" 
                                       class="form-control @error('seo_keywords') is-invalid @enderror" 
                                       placeholder="keyword1, keyword2, keyword3">
                                @error('seo_keywords')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Custom Meta Tags</label>
                                <textarea name="custom_metatags" rows="4" 
                                          class="form-control @error('custom_metatags') is-invalid @enderror" 
                                          placeholder="<meta name='...'>{{ old('custom_metatags') }}</textarea>
                                @error('custom_metatags')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Add custom HTML meta tags for advanced SEO</small>
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="active" name="active" {{ old('active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Biolink
                            </button>
                            <a href="{{ route('admin.biolinks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
