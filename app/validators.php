<?php
    /**
     * @file   validators.php
     * @brief  Contains custom validation
     * @author Sumit Chhetri
     * @date   6/14/14
     * @bug    No known bugs
     */


    Validator::extend('alpha_num_spaces', function ($attribute, $value) {
        return preg_match('/^[\pL\pN\s.]+$/u', $value);
    });