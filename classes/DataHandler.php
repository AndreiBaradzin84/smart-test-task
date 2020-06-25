<?php

class DataHandler {

    private $data;

    public function __construct( array $data ) {

        $this->data = $data;
    }

    public function getStats(): array {

        $stats = [];

        $stats['all'] = $this->countArray( $this->data );
        $unique_data = $this->getUnique( $this->data );

        $stats['unique'] = $this->countArray( $unique_data );

        arsort( $stats['all'] );
        arsort( $stats['unique'] );

        return $stats;
    }

    private function getUnique( array $data ): array {

        return array_map( "unserialize", array_unique( array_map( "serialize", $data ) ) );
    }

    private function countArray( array $data ): array {

        $result_array = [];

        foreach ( $data as $single_entry ) {
            if ( ! array_key_exists( $single_entry[0], $result_array ) ) {
                $result_array[ $single_entry[0] ] = 1;
                continue;
            }
            $result_array[ $single_entry[0] ] ++;
        }

        return $result_array;
    }
}
