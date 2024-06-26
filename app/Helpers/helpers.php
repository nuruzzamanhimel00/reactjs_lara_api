<?php


use Illuminate\Support\Facades\Storage;


if (!function_exists('store_file')) {

    function store_file($base64_path = null, $store_path = 'images')
    {

        try {
            $base64File = $base64_path;
            // Extract the MIME type from the base64 string
            preg_match('/^data:(\w+\/\w+);base64,/', $base64File, $matches);

            if (!isset($matches[1])) {
                throw new Exception("Invalid base64 string.");
            }
            $mimeType = $matches[1];
                // Decode the base64 file
            $fileData = base64_decode(preg_replace('/^data:\w+\/\w+;base64,/', '', $base64File));

            // Get the file extension based on the MIME type
            $extension = mimeToExtension($mimeType);

            // Save the resized image to a file
            $fileName = uniqid() .".". $extension;
            // Define the path to store the file
            $filePath = ($store_path.'/' . $fileName);

            Storage::disk('public')->put($filePath, $fileData);
            return $fileName;
        } catch (\Throwable $th) {
            throw $th;
        }

    }

}


//------ Store new Purchase -------------\\
function mimeToExtension($mimeType)
{
    $mimeMap = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/bmp' => 'bmp',
        'image/svg+xml' => 'svg',
        'application/pdf' => 'pdf',
        'text/plain' => 'txt',
        // Add more MIME types and their corresponding extensions as needed
    ];

    return isset($mimeMap[$mimeType]) ? $mimeMap[$mimeType] : 'bin';
}

function getStorageImage($path, $name, $is_user = false, $resizable = false)
{
    if (!is_null($name) && Storage::exists($path . '/' . $name)) {

        if ($resizable) {
            $full_path = 'storage/' . $path . '/' . $name;
            if ($name) {
                return $full_path;
            }
        }
        return  asset(config('app.url').'storage/' . $path . '/' . $name);
    }
return $is_user ? getUserDefaultImage() : getDefaultImage();
}
/**
 * getUserDefaultImage
 *
 * @return void
 */
function getUserDefaultImage()
{
    return  asset(config('app.url').'images/user_default.png');
}
/**
 * getDefaultImage
 *
 * @return void
 */
function getDefaultImage()
{
    return  asset(config('app.url').'images/default.png');
}

if (!function_exists('base64_path_check')) {

    function base64_path_check($path = null)
    {

        return preg_match('/^data:image\/(png|jpg|jpeg);base64,/', $path);

    }

}

if (!function_exists('delete_file')) {

    function delete_file($filePath = null)
    {

        if (Storage::exists($filePath)) {
            // Delete the file
            Storage::delete($filePath);

        }

    }

}
