<div>
    @if($channel->image)
        <img src="{{ asset('images' . '/' . $channel->image) }}" >
    @endif
    <form wire:submit.prevent="update">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="form-group">
            <lable for="name">Name:</lable>
            <input type="text" class="form-control" wire:model="channel.name">
        </div>
        @error('channel.name')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <div class="form-group">
            <lable for="slug">Slug:</lable>
            <input type="text" class="form-control" wire:model="channel.slug">
        </div>
        @error('channel.slug')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

            <div class="form-group">
                <input type="file" class="form-control-file" wire:model="image">
            </div>

            <div class="form-group">
                @if ($image)
                    Photo Preview:
                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail">
                @endif
            </div>

            @error('image')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror

        <div class="form-group">
            <lable for="description">Description:</lable>
            <textarea cols="30" rows="4" class="form-control" wire:model="channel.description"></textarea>
        </div>
        @error('channel.description')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

    </form>
</div>
