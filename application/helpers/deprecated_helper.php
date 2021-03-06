<?php
/**
 * @deprecated
 */
function get_table_items_html_and_taxes($items, $type, $admin_preview = false)
{
    return get_table_items_and_taxes($items, $type, $admin_preview);
}
/**
 * @deprecated
 */
function get_table_items_pdf_and_taxes($items, $type)
{
    return get_table_items_and_taxes($items, $type);
}

/**
 * @deprecated
 */
function get_project_label($id, $replace_default_by_muted = false)
{
    return project_status_color_class($id, $replace_default_by_muted);
}

/**
 * @deprecated
 */
function project_status_color_class($id, $replace_default_by_muted = false)
{
    if ($id == 1 || $id == 5) {
        $class = 'default';
        if ($replace_default_by_muted == true) {
            $class = 'muted';
        }
    } elseif ($id == 2) {
        $class = 'info';
    } elseif ($id == 3) {
        $class = 'warning';
    } else {
        // ID == 4 finished
        $class = 'success';
    }

    $hook_data = do_action('project_status_color_class', array(
        'id' => $id,
        'class' => $class,
    ));

    $class     = $hook_data['class'];

    return $class;
}

/**
 * @deprecated
 * Return class based on task priority id
 * @param  mixed $id
 * @return string
 */
function get_task_priority_class($id)
{
    if ($id == 1) {
        $class = 'muted';
    } elseif ($id == 2) {
        $class = 'info';
    } elseif ($id == 3) {
        $class = 'warning';
    } else {
        $class = 'danger';
    }

    return $class;
}

/**
 * @deprecated
 */
function project_status_by_id($id)
{
    $label = _l('project_status_'.$id);
    $hook_data = do_action('project_status_label', array('id'=>$id, 'label'=>$label));
    $label = $hook_data['label'];

    return $label;
}

/**
 * @deprecated
 */
function format_seconds($seconds)
{
    $minutes = $seconds / 60;
    $hours   = $minutes / 60;
    if ($minutes >= 60) {
        return round($hours, 2) . ' ' . _l('hours');
    } elseif ($seconds > 60) {
        return round($minutes, 2) . ' ' . _l('minutes');
    } else {
        return $seconds . ' ' . _l('seconds');
    }
}

/**
 * @deprecated
 */
function add_encryption_key_old()
{
    $CI =& get_instance();
    $key         = generate_encryption_key();
    $config_path = APPPATH . 'config/config.php';
    $CI->load->helper('file');
    @chmod($config_path, FILE_WRITE_MODE);
    $config_file = read_file($config_path);
    $config_file = trim($config_file);
    $config_file = str_replace("\$config['encryption_key'] = '';", "\$config['encryption_key'] = '" . $key . "';", $config_file);
    if (!$fp = fopen($config_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
        return false;
    }
    flock($fp, LOCK_EX);
    fwrite($fp, $config_file, strlen($config_file));
    flock($fp, LOCK_UN);
    fclose($fp);
    @chmod($config_path, FILE_READ_MODE);

    return $key;
}

/**
* @deprecated
* Function moved in main.js
*/
function app_admin_ajax_search_function()
{
    ?>
<script>
  function init_ajax_search(type, selector, server_data, url){

    var ajaxSelector = $('body').find(selector);
    if(ajaxSelector.length){
      var options = {
        ajax: {
          url: (typeof(url) == 'undefined' ? admin_url + 'misc/get_relation_data' : url),
          data: function () {
            var data = {};
            data.type = type;
            data.rel_id = '';
            data.q = '{{{q}}}';
            if(typeof(server_data) != 'undefined'){
              jQuery.extend(data, server_data);
            }
            return data;
          }
        },
        locale: {
          emptyTitle: "<?php echo _l('search_ajax_empty'); ?>",
          statusInitialized: "<?php echo _l('search_ajax_initialized'); ?>",
          statusSearching:"<?php echo _l('search_ajax_searching'); ?>",
          statusNoResults:"<?php echo _l('not_results_found'); ?>",
          searchPlaceholder:"<?php echo _l('search_ajax_placeholder'); ?>",
          currentlySelected:"<?php echo _l('currently_selected'); ?>",
        },
        requestDelay:500,
        cache:false,
        preprocessData: function(processData){
          var bs_data = [];
          var len = processData.length;
          for(var i = 0; i < len; i++){
            var tmp_data =  {
              'value': processData[i].id,
              'text': processData[i].name,
            };
            if(processData[i].subtext){
              tmp_data.data = {subtext:processData[i].subtext}
            }
            bs_data.push(tmp_data);
          }
          return bs_data;
        },
        preserveSelectedPosition:'after',
        preserveSelected:true
      }
      if(ajaxSelector.data('empty-title')){
        options.locale.emptyTitle = ajaxSelector.data('empty-title');
      }
      ajaxSelector.selectpicker().ajaxSelectPicker(options);
    }
  }
 </script>
<?php
}

/**
 * @deprecated
 */
function slug_it_old($str, $options = array()){

    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str      = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'separator' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(
            '
            /\b(??)\b/i' => 'gj',
            '/\b(??)\b/i' => 'ch',
            '/\b(??)\b/i' => 'sh',
            '/\b(??)\b/i' => 'lj'
        ),
        'transliterate' => true
    );
    // Merge options
    $options  = array_merge($defaults, $options);
    $char_map = array(
        // Latin
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'AE',
        '??' => 'C',
        '??' => 'E',
        '??' => 'E',
        '??' => 'E',
        '??' => 'E',
        '??' => 'I',
        '??' => 'I',
        '??' => 'I',
        '??' => 'I',
        '??' => 'D',
        '??' => 'N',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'U',
        '??' => 'U',
        '??' => 'U',
        '??' => 'U',
        '??' => 'U',
        '??' => 'Y',
        '??' => 'TH',
        '??' => 'ss',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'ae',
        '??' => 'c',
        '??' => 'e',
        '??' => 'e',
        '??' => 'e',
        '??' => 'e',
        '??' => 'i',
        '??' => 'i',
        '??' => 'i',
        '??' => 'i',
        '??' => 'd',
        '??' => 'n',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'u',
        '??' => 'u',
        '??' => 'u',
        '??' => 'u',
        '??' => 'u',
        '??' => 'y',
        '??' => 'th',
        '??' => 'y',
        // Latin symbols
        '??' => '(c)',
        // Greek
        '??' => 'A',
        '??' => 'B',
        '??' => 'G',
        '??' => 'D',
        '??' => 'E',
        '??' => 'Z',
        '??' => 'H',
        '??' => '8',
        '??' => 'I',
        '??' => 'K',
        '??' => 'L',
        '??' => 'M',
        '??' => 'N',
        '??' => '3',
        '??' => 'O',
        '??' => 'P',
        '??' => 'R',
        '??' => 'S',
        '??' => 'T',
        '??' => 'Y',
        '??' => 'F',
        '??' => 'X',
        '??' => 'PS',
        '??' => 'W',
        '??' => 'A',
        '??' => 'E',
        '??' => 'I',
        '??' => 'O',
        '??' => 'Y',
        '??' => 'H',
        '??' => 'W',
        '??' => 'I',
        '??' => 'Y',
        '??' => 'a',
        '??' => 'b',
        '??' => 'g',
        '??' => 'd',
        '??' => 'e',
        '??' => 'z',
        '??' => 'h',
        '??' => '8',
        '??' => 'i',
        '??' => 'k',
        '??' => 'l',
        '??' => 'm',
        '??' => 'n',
        '??' => '3',
        '??' => 'o',
        '??' => 'p',
        '??' => 'r',
        '??' => 's',
        '??' => 't',
        '??' => 'y',
        '??' => 'f',
        '??' => 'x',
        '??' => 'ps',
        '??' => 'w',
        '??' => 'a',
        '??' => 'e',
        '??' => 'i',
        '??' => 'o',
        '??' => 'y',
        '??' => 'h',
        '??' => 'w',
        '??' => 's',
        '??' => 'i',
        '??' => 'y',
        '??' => 'y',
        '??' => 'i',
        // Turkish
        '??' => 'S',
        '??' => 'I',
        '??' => 'C',
        '??' => 'U',
        '??' => 'O',
        '??' => 'G',
        '??' => 's',
        '??' => 'i',
        '??' => 'c',
        '??' => 'u',
        '??' => 'o',
        '??' => 'g',
        // Russian
        '??' => 'A',
        '??' => 'B',
        '??' => 'V',
        '??' => 'G',
        '??' => 'D',
        '??' => 'E',
        '??' => 'Yo',
        '??' => 'Zh',
        '??' => 'Z',
        '??' => 'I',
        '??' => 'J',
        '??' => 'K',
        '??' => 'L',
        '??' => 'M',
        '??' => 'N',
        '??' => 'O',
        '??' => 'P',
        '??' => 'R',
        '??' => 'S',
        '??' => 'T',
        '??' => 'U',
        '??' => 'F',
        '??' => 'H',
        '??' => 'C',
        '??' => 'Ch',
        '??' => 'Sh',
        '??' => 'Sh',
        '??' => '',
        '??' => 'Y',
        '??' => '',
        '??' => 'E',
        '??' => 'Yu',
        '??' => 'Ya',
        '??' => 'a',
        '??' => 'b',
        '??' => 'v',
        '??' => 'g',
        '??' => 'd',
        '??' => 'e',
        '??' => 'yo',
        '??' => 'zh',
        '??' => 'z',
        '??' => 'i',
        '??' => 'j',
        '??' => 'k',
        '??' => 'l',
        '??' => 'm',
        '??' => 'n',
        '??' => 'o',
        '??' => 'p',
        '??' => 'r',
        '??' => 's',
        '??' => 't',
        '??' => 'u',
        '??' => 'f',
        '??' => 'h',
        '??' => 'c',
        '??' => 'ch',
        '??' => 'sh',
        '??' => 'sh',
        '??' => '',
        '??' => 'y',
        '??' => '',
        '??' => 'e',
        '??' => 'yu',
        '??' => 'ya',
        // Ukrainian
        '??' => 'Ye',
        '??' => 'I',
        '??' => 'Yi',
        '??' => 'G',
        '??' => 'ye',
        '??' => 'i',
        '??' => 'yi',
        '??' => 'g',
        // Czech
        '??' => 'C',
        '??' => 'D',
        '??' => 'E',
        '??' => 'N',
        '??' => 'R',
        '??' => 'S',
        '??' => 'T',
        '??' => 'U',
        '??' => 'Z',
        '??' => 'c',
        '??' => 'd',
        '??' => 'e',
        '??' => 'n',
        '??' => 'r',
        '??' => 's',
        '??' => 't',
        '??' => 'u',
        '??' => 'z',
        // Polish
        '??' => 'A',
        '??' => 'C',
        '??' => 'e',
        '??' => 'L',
        '??' => 'N',
        '??' => 'o',
        '??' => 'S',
        '??' => 'Z',
        '??' => 'Z',
        '??' => 'a',
        '??' => 'c',
        '??' => 'e',
        '??' => 'l',
        '??' => 'n',
        '??' => 'o',
        '??' => 's',
        '??' => 'z',
        '??' => 'z',
        // Latvian
        '??' => 'A',
        '??' => 'C',
        '??' => 'E',
        '??' => 'G',
        '??' => 'i',
        '??' => 'k',
        '??' => 'L',
        '??' => 'N',
        '??' => 'S',
        '??' => 'u',
        '??' => 'Z',
        '??' => 'a',
        '??' => 'c',
        '??' => 'e',
        '??' => 'g',
        '??' => 'i',
        '??' => 'k',
        '??' => 'l',
        '??' => 'n',
        '??' => 's',
        '??' => 'u',
        '??' => 'z'
    );
    // Make custom replacements
    $str      = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    // Replace non-alphanumeric characters with our separator
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['separator'], $str);
    // Remove duplicate separators
    $str = preg_replace('/(' . preg_quote($options['separator'], '/') . '){2,}/', '$1', $str);
    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    // Remove separator from ends
    $str = trim($str, $options['separator']);

    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}
