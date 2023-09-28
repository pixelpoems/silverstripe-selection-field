# Silverstripe Selection Field
[![stability-beta](https://img.shields.io/badge/stability-beta-33bbff.svg)](https://github.com/mkenney/software-guides/blob/master/STABILITY-BADGES.md#beta)

This module provides a selection field wich is based on [color palate field by heyday](https://github.com/heyday/silverstripe-colorpalette).

* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [Reporting Issues](#reporting-issues)
* [Credits](#credits)

## Requirements

* Silverstripe CMS >=4.0
* Silverstripe Framework >=4.0
* Versioned Admin >=1.0
* [Silverstripe Color Palette Field ^2.1](https://github.com/heyday/silverstripe-colorpalette)

## Installation
```
composer require pixelpoems/silverstripe-selection-field
```

## Usage
Based on: `SilverStripe\Forms\OptionsetField` and `Heyday\ColorPalette\Fields\ColorPaletteField`
```php
private static $db = [
    'Alignment' => 'Varchar',
];

private static $defaults = [
    'Alignment' => 'left',
];

public function getCMSFields()
{
    $fields = parent::getCMSFields();

    $fields->addFieldsToTab('Root.Main', [

        SelectionField::create(
           $name = 'Alignment',
           $title = 'Alignment',
           $source = [
                'left' => [
                    'Value' => 'left',
                    'Title' => _t('LayoutOptions.Left', "Left"),
                    'ShowTitle' => true,
                    'Icon' => 'align-left'
                ],
                'center' => [
                    'Value' => 'center',
                    'Title' => _t('LayoutOptions.Center', "Center"),
                    'ShowTitle' => true,
                    'Icon' => 'align-center'
                ],
                'right' => [
                    'Value' => 'right',
                    'Title' => _t('LayoutOptions.Right', "Right"),
                    'ShowTitle' => true,
                    'Icon' => 'align-right'
                ],
                $value = 'left'
        );

    ]);
}
```
![example-alignment.png](resources%2Fexample-alignment.png)

To display Icons you need to reference Feather Icons:
https://github.com/feathericons/feather/tree/main/icons

If no Icon is defined within the array, the box will display the title!
You can define an alternative box content when you define "Content" within Options:
```php
'medium' => [
    'Value' => 'medium',
    'Title' => _t('LayoutOptions.Medium', 'Medium'),
    'ShowTitle' => true,
    'Content' => 'M'
],
```

## Reporting Issues
Please [create an issue](https://github.com/pixelpoems/silverstripe-selection-field/issues) for any bugs you've found, or
features you're missing.

## Credits
Icons from [Feather Icons](https://feathericons.com/) \
Selection Field is based on [Heyday's Color Palette Field](https://github.com/heyday/silverstripe-colorpalette)
