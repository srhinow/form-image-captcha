-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


--
-- Table `tl_form_field`
--

CREATE TABLE `tl_form_field` (
`fic_width` varchar(5) NOT NULL default '',
`fic_height` varchar(5) NOT NULL default '',
`fic_fontcolor` varchar(25) NOT NULL default '',
`fic_linecolor` varchar(25) NOT NULL default '',
`fic_bgcolor` varchar(5) NOT NULL default '',
`fic_length` varchar(5) NOT NULL default '',
`fic_fontsize` varchar(5) NOT NULL default '',
`fic_charset` varchar(5) NOT NULL default '',
`fic_charspace` varchar(5) NOT NULL default '',
`fic_angle` varchar(5) NOT NULL default '',
`fic_padding` varchar(5) NOT NULL default '',
`fic_font` varchar(254) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;