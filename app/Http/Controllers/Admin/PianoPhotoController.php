<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Piano;
use App\Models\PianoPhoto;
use Illuminate\Http\Request;

class PianoPhotoController extends Controller
{
    public function store(Request $request, Piano $piano)
    {
        $request->validate([
            'photos.*' => 'required|image|max:5120',
        ]);

        foreach ($request->file('photos', []) as $i => $file) {
            $path = $file->store('pianos', 'public');
            PianoPhoto::create([
                'piano_id' => $piano->id,
                'path' => $path,
                'filename' => $file->getClientOriginalName(),
                'alt_text' => $piano->name,
                'sort_order' => $piano->photos()->count() + $i,
                'is_primary' => $piano->photos()->count() === 0 && $i === 0,
            ]);
        }

        return back()->with('success', 'Photos uploaded successfully.');
    }

    public function destroy(Piano $piano, PianoPhoto $photo)
    {
        $photo->delete();
        return back()->with('success', 'Photo removed.');
    }
}
