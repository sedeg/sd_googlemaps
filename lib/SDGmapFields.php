<?php
defined('ABSPATH') or die('No script kiddies please!');


class SDGmapFields
{

	/**
	 * @var string  available field types
	 */
	const FIELD_TYPE_INPUT          = 'input';
	const FIELD_TYPE_TEXTAREA       = 'textarea';
	const FIELD_TYPE_SELECT         = 'select';
	const FIELD_TYPE_LINK           = 'link';
	const FIELD_TYPE_WYSIWYG        = 'wysiwyg';
	const FIELD_TYPE_ATTACHMENT     = 'attachment';
	const FIELD_TYPE_CHECKBOX       = 'checkbox';
	const FIELD_TYPE_CHECKBOX_GROUP = 'checkbox_group';

	/**
	 * @var array   exclude outer label for field types
	 */
	const EXCLUDES_OUTER_LABEL  = [
		self::FIELD_TYPE_CHECKBOX,
		self::FIELD_TYPE_CHECKBOX_GROUP,
	];


	/**
	 * @param array $field
	 */
	public static function createField(array $field = [])
	{
		$output = '';

		if (!empty($field)) {
			if((!empty($field['label'])) && (!in_array($field['fieldtype'], self::EXCLUDES_OUTER_LABEL))) {
				$output .= '<label for="' . $field['name'] . '">' . $field['label'] . '</label>';
			}

			$descriptonClass    = (!empty($field['description_class'])) ? ' '.$field['description_class']   : '';
			$inputClass         = (!empty($field['input_class']))       ? ' '.$field['input_class']         : '';
			$inputValue         = (!empty($field['value']))             ? 'value="'.$field['value'].'"'    : '';

			switch ($field['fieldtype']) {
				case self::FIELD_TYPE_INPUT:
					$output .=  self::createFieldInput($field, $inputValue, $inputClass);
					break;
				case self::FIELD_TYPE_TEXTAREA:
					$output .= self::createFieldTextarea($field, $inputClass);
					break;
				case self::FIELD_TYPE_SELECT:
					$output .= self::createFieldSelect($field, $inputClass);
					break;
				case self::FIELD_TYPE_LINK:
					$output .= self::createFieldLink($field, $inputValue, $inputClass);
					break;
				case self::FIELD_TYPE_WYSIWYG:
					$output .= self::createFieldWysiwyg($field);
					break;
				case self::FIELD_TYPE_ATTACHMENT:
					$output .= self::createFieldAttachment($field);
					break;
			} // end switch

			if(!empty( $field['description'])) {
				$output .= '<p class="description' . $descriptonClass . '">' . $field['description'] . '</p>';
			}
		}

		echo $output;
	}


	/**
	 * @param array $field
	 * @param null $inputValue
	 * @param null $inputClass
	 * @return string
	 */
	protected static function createFieldInput(array $field, $inputValue=null, $inputClass=null)
	{
		$attr   = '';

		// assemble attributes
		foreach(((isset($field['attr']) && (is_array($field['attr']))) ? $field['attr'] : []) as $attr_key => $attr_value) {
			$attr   .= sprintf('%s="%s"', $attr_key, $attr_value);
		}

		return
			'<input id="' . $field['name'] . '" type="' . $field['type'] . '" placeholder="' . $field['placeholder'] . '" name="' . $field['name'] . '" class="sd_input'.$inputClass.'" '.$inputValue.$attr.'>'
			;
	}

	/**
	 * @param array $field
	 * @param null $inputClass
	 * @return string
	 */
	protected static function createFieldTextarea(array $field, $inputClass=null)
	{
		$textareaValue  = (!empty($field['value'])) ? $field['value'] : '';

		return
			'<textarea id="' . $field['name'] . '" name="' . $field['name'] . '" class="sd_input'.$inputClass.'" rows="' . $field['rows'] . '">'
			.$textareaValue
			.'</textarea>'
			;
	}

	/**
	 * @param array $field
	 * @param null $inputClass
	 * @return string
	 */
	protected static function createFieldSelect(array $field, $inputClass=null)
	{
		$selectValue    = (!empty($field['value'])) ? $field['value'] : '';

		$html   = '<select id="' . $field['name'] . '" name="' . $field['name'] . '" class="sd_input'.$inputClass.'">';

		foreach($field['options'] as $text=>$value) {
			$selected   = ($value == $selectValue) ? 'selected' : '';
			$html       .= '<option value="' . $value . '" '.$selected.'>'.$text.'</option>';
		}

		$html   .= '</select>';

		return $html;
	}

	/**
	 * @param array $field
	 * @param null $inputValue
	 * @param null $inputClass
	 * @return string
	 */
	protected static function createFieldLink(array $field, $inputValue=null, $inputClass=null)
	{
		return
			'<input value="' . $field['button_value'] . '" id="' . $field['name'] . '" type="button" name="' . $field['name'] . '_button" class="link-button button'.$inputClass.'">'
			.'<input id="fu" type="text" name="' . $field['name'] . '" class="link-value" '.$inputValue.'>'
			;
	}

	/**
	 * @param array $field
	 */
	protected static function createFieldWysiwyg(array $field)
	{
		$wysiwygValue   = (!empty($field['value'])) ? $field['value'] : '';

		$settings       = [
			'textarea_rows' => 7,
			'media_buttons' => false,
			'wpautop'       => false,
			'textarea_name' => $field['name'],
		];

		return wp_editor($wysiwygValue, $field['name'], $settings);
	}

	/**
	 * @param array $field
	 * @return string
	 */
	protected static function createFieldAttachment(array $field)
	{
		$field['value'] = (!empty($field['value'])) ? $field['value'] : '';

		if(!empty($field['value']))
			$attachments = explode(',', $field['value']);

		$html = '<div class="attachments-list">';

		if((!empty($attachments)) && ($attachments[0]!='')) {
			foreach ($attachments as $attachment) {
				$postAttachment = get_post(intval($attachment));

				if((isset($postAttachment->post_title)) && ($postAttachment->post_title!='')) {
					$title  = $postAttachment->post_title;
				} else {
					$title  = basename(isset($postAttachment->guid) ? $postAttachment->guid : '');
				}

				$html .= '<div class="attachment-wrap">';
				$html   .= '<div>'.esc_html($title).' ('.size_format(filesize(get_attached_file($attachment))).')</div>';
				$html   .= '<div data-attachment-id="'.intval($attachment).'" class="button remove-attachment"><span class="dashicons dashicons-trash"></span></div>';
				$html .= '</div>';
			}
		}
		$html .= '</div>';
		$html .=	'<input type="button" name="'.$field['upload_name'].'" id="upload-attachments" class="button-secondary attachment-manager" value="'.$field['upload_value'].'">';
		$html .= '<input type="hidden" class="regular-text attachment" id="attachments" name="'.$field['name'].'" value="'.$field['value'].'">';
		wp_enqueue_script('jquery');
		wp_enqueue_media();

		return $html;
	}
}
