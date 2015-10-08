<?php
/**
 * ****************************************************************************
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  XOOPS Project     
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         
 * @author 	   		
 *
 * Version : $Id:
 * ****************************************************************************
 */

include_once 'admin_header.php';
xoops_cp_header();

$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation('index.php');
echo $indexAdmin->renderIndex();

include 'admin_footer.php';
