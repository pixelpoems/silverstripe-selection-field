<?php

namespace Pixelpoems\SelectionField\Services;


use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Core\Config\Configurable;

class IconSelectionService
{
    use Configurable;

    private static string $image_folder_name = 'Icons';

    public static function getIconOptions(): array
    {
        $folder = Folder::find_or_make('/' . self::config()->get('image_folder_name'));
        $files = File::get()->filter(['ParentID' => $folder->ID]);

        $imgMap = [];
        foreach ($files as $file) {
            if($file->Link()) {
                $data = [
                    'ImgLink' => $file->Link(),
                    'Value' => (string)$file->ID,
                    'Title' => $file->Title
                ];

                $imgMap[$file->ID] = $data;
            }
        }
        return $imgMap;
    }

}
