CREATE TABLE tt_content (
    tx_bwgallery_pagination int(11) DEFAULT '0' NOT NULL,
    tx_bwgallery_pagination_top tinyint(3) DEFAULT '0' NOT NULL,
    tx_bwgallery_pagination_bottom tinyint(3) DEFAULT '0' NOT NULL,
    tx_bwgallery_pagination_elements int(11) DEFAULT '48' NOT NULL,
    tx_bwgallery_categories tinyint(3) DEFAULT '0' NOT NULL,
    tx_bwgallery_columns int(11) DEFAULT '6' NOT NULL,
    tx_bwgallery_limit int(11) DEFAULT '0' NOT NULL,
    tx_bwgallery_limit_number int(11) DEFAULT '6' NOT NULL,
);