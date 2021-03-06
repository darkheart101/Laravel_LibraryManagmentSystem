<?php

    namespace App\Http\Repositories\RepositoryInterfaces;

    interface BaseRepoInterface{

        public function get_all_limit_by( $limit = 0);
        public function get_record_by_id( $id );
        public function create_record( $data );
        public function update_record( $data );
        public function delete_record_byID( $id );

    }