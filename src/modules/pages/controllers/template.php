<?php

/**
 * @author  : Adnan Mokhtar
 * @link    : 
 * @email   : iconxweb@gmail.com
 * @name    : Template
 * @version : 1
 * @since   : 11 Jul 2015 (Version 1)
 * @todo    : get template files
 * */
class Template {

    public $path;

//=========================================================
// CONSTRUCTOR
//=========================================================
    final public function __construct() {
        $this->path = base_path() . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'views';
    }

    public function get_templates() {
        $files = (array) $this->get_files('php', 1);
        $page_templates = array();

        foreach ($files as $file => $full_path) {
            if (!preg_match('|Template Name:(.*)$|mi', file_get_contents($full_path), $header))
                continue;

            $fill = strtr($file, array(".blade.php" => ""));
            $page_templates[$file] = $this->cleanup_header_comment($header[1]);
        }

        return $page_templates;
    }

    /**
     * Strip close comment and close php tags from file headers used by WP.
     *
     * @since 2.8.0
     * @access private
     *
     * @see https://core.trac.wordpress.org/ticket/8497
     *
     * @param string $str Header comment to clean up.
     * @return string
     */
    public function cleanup_header_comment($str) {
        return trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $str));
    }

    /**
     * Return files in the theme's directory.
     *
     * @since 3.4.0
     * @access public
     *
     * @param mixed $type Optional. Array of extensions to return. Defaults to all files (null).
     * @param int $depth Optional. How deep to search for files. Defaults to a flat scan (0 depth). -1 
      depth is infinite.
     * @param bool $search_parent Optional. Whether to return parent files. Defaults to false.
     * @return array Array of files, keyed by the path to the file relative to the theme's directory, with 
      the values
     * 	being absolute paths.
     */
    public function get_files($type = null, $depth = 0, $search_parent = false) {
        $files = (array) self::scandir($this->path, $type, $depth);

//        if ($search_parent && $this->parent())
//            $files += (array) self::scandir($this->get_template_directory(), $type, $depth);

        return $files;
    }

    /**
     * Scans a directory for files of a certain extension.
     *
     * @since 3.4.0
     * @access private
     *
     * @param string $path Absolute path to search.
     * @param mixed  Array of extensions to find, string of a single extension, or null for all extensions.
     * @param int $depth How deep to search for files. Optional, defaults to a flat scan (0 depth). -1 depth is infinite.
     * @param string $relative_path The basename of the absolute path. Used to control the returned path
     * 	for the found files, particularly when this function recurses to lower depths.
     */
    public function scandir($path, $extensions = null, $depth = 0, $relative_path = '') {
        if (!is_dir($path))
            return false;

        if ($extensions) {
            $extensions = (array) $extensions;
            $_extensions = implode('|', $extensions);
        }

        $relative_path = self::trailingslashit($relative_path);
        if ('/' == $relative_path)
            $relative_path = '';

        $results = scandir($path);
        $files = array();

        foreach ($results as $result) {
            if ('.' == $result[0])
                continue;
            if (is_dir($path . '/' . $result)) {
                if (!$depth || 'CVS' == $result)
                    continue;
                $found = self::scandir($path . '/' . $result, $extensions, $depth - 1, $relative_path . $result);
                $files = array_merge_recursive($files, $found);
            } elseif (!$extensions || preg_match('~\.(' . $_extensions . ')$~', $result)) {
                $files[$relative_path . $result] = $path . '/' . $result;
            }
        }

        return $files;
    }

    /**
     * Appends a trailing slash.
     *
     * Will remove trailing forward and backslashes if it exists already before adding
     * a trailing forward slash. This prevents double slashing a string or path.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 1.2.0
     *
     * @param string $string What to add the trailing slash to.
     * @return string String with trailing slash added.
     */
    public function trailingslashit($string) {
        return self::untrailingslashit($string) . '/';
    }

    /**
     * Removes trailing forward slashes and backslashes if they exist.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 2.2.0
     *
     * @param string $string What to remove the trailing slashes from.
     * @return string String without the trailing slashes.
     */
    public function untrailingslashit($string) {
        return rtrim($string, '/\\');
    }

}
