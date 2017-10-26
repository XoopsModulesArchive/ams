<?php
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
class AMSPageNav extends XoopsPageNav
{
    public $friendlyurl_enable;
    public $friendlyurl;
    public function __construct($total_items, $items_perpage, $current_start, $start_name="start", $extra_arg="", $friendlyurl_enable=0, $friendlyurl="")
    {
        $this->total = intval($total_items);
        $this->perpage = intval($items_perpage);
        $this->current = intval($current_start);
        $this->friendlyurl_enable = $friendlyurl_enable;
        $this->friendlyurl = substr($friendlyurl, 0, strlen($friendlyurl)-5);
        if ('' != $extra_arg && ('&amp;' != substr($extra_arg, -5) || '&' != substr($extra_arg, -1))) {
            $extra_arg .= '&amp;';
        }
        if (1 == $friendlyurl_enable) {
            $this->url = $this->friendlyurl;
        } else {
            $this->url = xoops_getenv('PHP_SELF').'?'.$extra_arg.trim($start_name).'=';
        }
    }

    public function renderNav($offset = 4)
    {
        $ret = '';
        if ($this->total <= $this->perpage) {
            return $ret;
        }
        $total_pages = ceil($this->total / $this->perpage);
        if ($total_pages > 1) {
            $prev = $this->current - $this->perpage;
            if ($prev >= 0) {
                if (1 == $this->friendlyurl_enable) {
                    $ret .= '<a href="'.$this->url.$prev.'.htm"><u>&laquo;</u></a> ';
                } else {
                    $ret .= '<a href="'.$this->url.$prev.'"><u>&laquo;</u></a> ';
                }
            }
            $counter = 1;
            $current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
            while ($counter <= $total_pages) {
                if ($counter == $current_page) {
                    $ret .= '<b>('.$counter.')</b> ';
                } elseif (($counter > $current_page-$offset && $counter < $current_page + $offset) || 1 == $counter || $counter == $total_pages) {
                    if ($counter == $total_pages && $current_page < $total_pages - $offset) {
                        $ret .= '... ';
                    }
                    if (1 == $this->friendlyurl_enable) {
                        $ret .= '<a href="'.$this->url.(($counter - 1) * $this->perpage).'.htm">'.$counter.'</a> ';
                    } else {
                        $ret .= '<a href="'.$this->url.(($counter - 1) * $this->perpage).'">'.$counter.'</a> ';
                    }
                    if (1 == $counter && $current_page > 1 + $offset) {
                        $ret .= '... ';
                    }
                }
                $counter++;
            }
            $next = $this->current + $this->perpage;
            if ($this->total > $next) {
                if (1 == $this->friendlyurl_enable) {
                    $ret .= '<a href="'.$this->url.$next.'.htm"><u>&raquo;</u></a> ';
                } else {
                    $ret .= '<a href="'.$this->url.$next.'"><u>&raquo;</u></a> ';
                }
            }
        }
        return $ret;
    }
}
