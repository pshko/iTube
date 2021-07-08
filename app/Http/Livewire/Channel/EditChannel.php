<?php

namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditChannel extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $image;
    public $channel;
    protected function rules() {
        return [
            'channel.name' => 'required|max:255|unique:channels,name,' .$this->channel->id,
            'channel.slug' => 'required|max:255|unique:channels,slug,' .$this->channel->id,
            'channel.description' => 'nullable|max:1000',
            'image' => 'nullable|image|max:1024',
        ];
    }

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }
    public function render()
    {
        return view('livewire.channel.edit-channel');
    }

    public function update()
    {
        $this->authorize('update', $this->channel);
        $this->validate();

        $this->channel->update([
            'name' => $this->channel->name,
            'slug' => $this->channel->slug,
            'description' => $this->channel->description,
        ]);

        // Checked if Image is submitted
        if($this->image)
        {
            // Store image
            $image = $this->image->storeAs('images', $this->channel->uid . '.png');
            $imageImage = explode('/', $image)[1];
            // Resize and convert to .png
            $img = Image::make(storage_path() . '/app/' . $image)
                ->encode('png')
                ->fit(80, 80, function ($constraint) {
                    $constraint->upsize();
                })->save();
            ;

            // Update in database
            $this->channel->update([
                'image' => $imageImage,
            ]);
        }
        session()->flash('message', 'Channel Updated Successfully!');
        return redirect()->route('channel.edit', ['channel' => $this->channel->slug]);
    }
}
