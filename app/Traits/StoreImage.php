<?php 

namespace App\Traits;

trait StoreImage {

    public function storeImage($request, $image, $path) {

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $image_name = time() . '.' . $image->getClientOriginalExtension();

            $image->storeAs($path, $image_name, 'public');
            return $image_name;
        }
    }
}