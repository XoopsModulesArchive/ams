<?php
// $Id$
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
include '../../../include/cp_header.php';
include 'functions.php';
xoops_cp_header();

adminmenu(-1);
echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td width='100%' class=\"odd\">";
echo "<center><b>AMS Brought To You By:</b></center><br />";
echo "<center><a href='http://www.it-hq.org' target='_blank'><h3>IT Headquarters</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.iis-resources.com' target='_blank'>IIS Resources</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.web-udvikling.dk' target='_blank'>JKP Software Development</h3></a></center><br />";
echo '</td></tr></table>';
echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr>";
echo "<td width='48%' class=\"odd\">";
echo "<center><b>AMS Module Support</b></center><br />";
echo "Need help with using AMS? <br /><br />- <a href='http://www.it-hq.org/modules/smartfaq/category.php?categoryid=2' target='_blank'>AMS User Documentation</a><br /><br />";
echo "Still need additional support?<br /><br />- <a href='http://www.it-hq.org/modules/newbb/' target='_blank'>AMS Support Forums</a><br /><br />";
echo "Note: Donators will given priority support in a dedicated forum.<br /><br />";
echo "</td>";
echo "<td width='48%' class=\"odd\">";
echo "<center><b>Make A Donation</b></center><br />Thank you very much for using AMS. If you find the AMS module useful and plan to use it on your site, please show your appreciation by making a small donation to ensure its ongoing development. <br /><br />";
echo "<center><form action='https://www.paypal.com/cgi-bin/webscr' method='post'><input type='hidden' name='cmd' value='_s-xclick'><input type='image' src='https://www.paypal.com/en_US/i/btn/x-click-but21.gif' border='0' name='submit' alt='Make payments with PayPal - it's fast, free and secure!'><input type='hidden' name='encrypted' value='-----BEGIN PKCS7-----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-----END PKCS7-----'></form></center>";
echo '</td></tr></table>';


xoops_cp_footer();
?>