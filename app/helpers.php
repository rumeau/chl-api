<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 014 14/01/2015
 * Time: 12:02
 */

use Illuminate\Pagination\AbstractPaginator;

if (!function_exists('gravatar')) {
    /**
     * @param $email
     * @param array $options
     * @return string
     */
    function gravatar($email, $options = [])
    {
        $url = Config::get('services.gravatar.base_url');

        $hashEmail = md5(strtolower(trim($email)));

        $url .= $hashEmail;
        $options = array_merge(Config::get('services.gravatar.options'), $options);
        $schema = Config::get('services.gravatar.https', false) ? 'http://' : 'https://';
        return $schema . $url . '?' . query_string($options);
    }
}

if (!function_exists('query_string')) {
    /**
     * @param array $parameters
     * @return string
     */
    function query_string($parameters = [])
    {
        if (empty($parameters)) {
            return '';
        }

        $newParameters = [];
        foreach ($parameters as $key => $val) {
            $newParameters[] = rawurldecode("$key=$val");
        }

        return implode('&amp;', $newParameters);
    }
}

if (!function_exists('first_name')) {
    /**
     * @param null $name
     * @return string
     */
    function first_name($name = null) {
        if ($name === null) {
            $name = Auth::user()->name;
        }

        $firstName = explode(' ', $name);

        if (isset($firstName[0])) {
            return $firstName[0];
        }

        return '';
    }
}

if (!function_exists('sort_link')) {

    function sort_link(AbstractPaginator $paginator, $property, $label = null) {
        /**
         * @var string $by
         * @var string $order
         */
        $order = Input::query('order', 'ASC');
        $by    = Input::query('by', null);

        if (null === $label) {
            $label = ucwords($property);
        }

        if ($by == $property) {
            $order = $order === 'DESC' ? 'ASC' : 'DESC';
        }
        $by = $property;

        $order = strtoupper($order);

        if (!in_array($order, ['ASC', 'DESC'])) {
            $order = 'ASC';
        }

        // Add parameters to the paginator
        $paginator->appends(compact('order', 'by', 'q'));
        $url   = $paginator->url($paginator->currentPage());
        // Clean default parameters
        $paginator->appends(['order' => '', 'by' => '']);

        return '<a href="' . $url . '" title="' . $label . '">' . $label .'</a>';
    }
}


if (!function_exists('format_rut')) {
    /**
     * @param $string
     * @return string
     */
    function format_rut($string) {
        $rut = substr($string, 0, -1);
        $dv  = substr($string, -1);

        return number_format($rut, 0, ',', '.') . '-' . strtoupper($dv);
    }
}