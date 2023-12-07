<?php

namespace Pixelpoems\SelectionField\CMSFields;

use SilverStripe\Core\Convert;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\SingleSelectField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;


/**
 * Based on:
 * SilverStripe\Forms\OptionsetField
 * and
 * https://github.com/heyday/silverstripe-colorpalette
 *
 *
 * <b>Usage</b>
 *
 * <code>
 * new SelectionField(
 *    $name = "Foobar",
 *    $title = "FooBar's selection",
 *    $source = [
 *         'left' => [
 *             'Value' => 'left',
 *             'Title' => _t('LayoutOptions.Left', "Left"),
 *             'ShowTitle' => true,
 *             'Icon' => 'align-left'
 *         ],
 *         'center' => [
 *             'Value' => 'center',
 *             'Title' => _t('LayoutOptions.Center', "Center"),
 *             'ShowTitle' => true,
 *             'Icon' => 'align-center'
 *         ],
 *         'right' => [
 *             'Value' => 'right',
 *             'Title' => _t('LayoutOptions.Right', "Right"),
 *             'ShowTitle' => true,
 *             'Icon' => 'align-right'
 *         ],
 *    $value = "left"
 * );
 * </code>
 *
 * To display Icons you need to reference Feather Icons:
 * https://github.com/feathericons/feather/tree/main/icons
 *
 * If no Icon is defined within the array, the box will display the title!
 * You can define an alternative box content when you define "Content" within Options:
 * <code>
 * 'medium' => [
 *     'Value' => 'medium',
 *     'Title' => _t('LayoutOptions.Medium', "Medium"),
 *     'ShowTitle' => true,
 *     'Content' => 'M'
 * ],
 * </code>
 */
class SelectionField extends SingleSelectField
{
    protected function getFieldOption($value, $title, $odd, $showTitle, $icon = null, $content = null, $imgLink = null)
    {
        return new ArrayData([
            'ID' => $this->getOptionID($value),
            'Class' => $this->getOptionClass($value, $odd),
            'Role' => 'option',
            'Name' => $this->getOptionName(),
            'Value' => $value,
            'Title' => $title,
            'ShowTitle' => $showTitle,
            'Icon' => $icon,
            'Content' => $content,
            'ImgLink' => $imgLink,
            'isChecked' => $this->isSelectedValue($value, $this->Value()),
            'isDisabled' => $this->isDisabledValue($value)
        ]);
    }

    /**
     * Generate an ID property for a single option
     *
     * @param string $value
     * @return string
     */
    protected function getOptionID($value)
    {
        return $this->ID() . '_' . Convert::raw2htmlid($value);
    }

    /**
     * Get the "name" property for each item in the list
     *
     * @return string
     */
    protected function getOptionName()
    {
        return $this->getName();
    }

    /**
     * Get extra classes for each item in the list
     *
     * @param string $value Value of this item
     * @param bool $odd If this item is odd numbered in the list
     * @return string
     */
    protected function getOptionClass($value, $odd)
    {
        $oddClass = $odd ? 'odd' : 'even';
        $valueClass = ' val' . Convert::raw2htmlid($value);
        return $oddClass . $valueClass;
    }

    public function Field($properties = [])
    {
        Requirements::css('pixelpoems/silverstripe-selection-field:client/dist/css/selection-field.min.css');
        Requirements::javascript('pixelpoems/silverstripe-selection-field:client/dist/javascript/selection-field.min.js');

        $options = [];
        $odd = false;

        // Add all options striped
        foreach ($this->getSourceEmpty() as $item) {
            $odd = !$odd;
            $icon = $item['Icon'] ?? null;
            $content = $item['Content'] ?? null;
            $imgLink = $item['ImgLink'] ?? null;
            $showTitle = $item['ShowTitle'] ?? false;
            $options[] = $this->getFieldOption($item['Value'], $item['Title'], $odd, $showTitle, $icon, $content, $imgLink);
        }

        $properties = array_merge($properties, [
            'Options' => new ArrayList($options)
        ]);

        return FormField::Field($properties);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($validator)
    {
        if (!$this->Value()) {
            return true;
        }

        return parent::validate($validator);
    }

    public function getAttributes()
    {
        $attributes = array_merge(
            parent::getAttributes(),
            ['role' => 'listbox']
        );

        unset($attributes['name']);
        unset($attributes['required']);
        return $attributes;
    }

    public function Type(): string
    {
        return 'field selection-field';
    }
}
