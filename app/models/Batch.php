<?php
/**
 * @file Batch.php
 * @brief This class is an Eloquent model for 'batches' table
 *
 * Contains all the functions required to perform CRUD operations on 'batches' table.
 * It also contains validation function to perform validation on the data that are to be filled in 'batches' table.
 * @author SHhetri
 * @date 5/24/14
 * @bug No known bugs
 */


class Batch extends Eloquent{

    protected $fillable = ['batch_no,batch_year'];

} 