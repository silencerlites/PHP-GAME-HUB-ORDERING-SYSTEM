@php($currentImage = isset($game) ? $game->image_src : null)
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label fw-semibold">Game Title</label>
        <input class="form-control form-control-lg" name="title" value="{{ old('title',$game->title ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Platform</label>
        <select class="form-select form-select-lg" name="platform" required>
            @foreach(['Nintendo Switch','Nintendo 3DS','PSP','PlayStation 4','PlayStation 5','Xbox One','Xbox Series X|S','PC'] as $platform)
                <option value="{{ $platform }}" @selected(old('platform',$game->platform ?? '')===$platform)>{{ $platform }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Genre</label>
        <input class="form-control" name="genre" value="{{ old('genre',$game->genre ?? '') }}" placeholder="RPG, Racing, Action...">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Price (₱)</label>
        <input class="form-control" type="number" step="0.01" min="0" name="price" value="{{ old('price',$game->price ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Stock</label>
        <input class="form-control" type="number" min="0" name="stock_quantity" value="{{ old('stock_quantity',$game->stock_quantity ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Status</label>
        <select class="form-select" name="status">
            <option value="active" @selected(old('status',$game->status ?? 'active')==='active')>Active</option>
            <option value="inactive" @selected(old('status',$game->status ?? 'active')==='inactive')>Inactive</option>
        </select>
    </div>

    <div class="col-md-8">
        <label class="form-label fw-semibold">Game Cover Image <span class="text-secondary fw-normal">(optional)</span></label>
        <input class="form-control" id="game-image-input" type="file" name="image" accept="image/jpeg,image/png,image/webp">
        <div class="form-text">JPG, JPEG, PNG, or WEBP. Maximum file size: 4 MB.</div>
        @if($currentImage)
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" value="1" id="remove_image" name="remove_image" @checked(old('remove_image'))>
                <label class="form-check-label text-danger" for="remove_image">Remove current image</label>
            </div>
        @endif
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold d-block">Image Preview</label>
        <div class="upload-preview" id="game-image-preview">
            @if($currentImage)
                <img src="{{ $currentImage }}" alt="{{ $game->title }} cover preview">
            @else
                <div class="upload-preview-empty"><i class="bi bi-image"></i><span>No image selected</span></div>
            @endif
        </div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea class="form-control" name="description" rows="5">{{ old('description',$game->description ?? '') }}</textarea>
    </div>
</div>

@push('scripts')
<script>
(() => {
    const input = document.getElementById('game-image-input');
    const preview = document.getElementById('game-image-preview');
    const removeCheckbox = document.getElementById('remove_image');
    if (!input || !preview) return;

    input.addEventListener('change', () => {
        const file = input.files && input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = event => {
            preview.innerHTML = '';
            const image = document.createElement('img');
            image.src = event.target.result;
            image.alt = 'Selected game cover preview';
            preview.appendChild(image);
            if (removeCheckbox) removeCheckbox.checked = false;
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endpush
