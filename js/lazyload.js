/**
 * Plazart Framework
 * Author: Sonle
 * Date: 2/16/13
 * Time: 11:30 AM
 * @copyright   Copyright (C) 2012 - 2013 TemPlaza.com. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

jQuery(document).ready(function(){
    jQuery("img").each(function (i,el){
        var lazyimg = jQuery(this);
        lazyimg.attr('data-original',lazyimg.attr('src'));
        lazyimg.attr('src','')
    });
});

jQuery(window).load(function(){

});