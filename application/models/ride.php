<?php

class ride extends CI_Model{
    
    function retrieve_relevant() {
        $rides_personal = $this->ride->retrieve_personal();
        $rides_active = $this->ride->retrieve_active();

        // Order matters in this function.
        // We want to preserve elements in personal rides.
        $rides = $rides_personal + $rides_active;

        return $rides;
    }

    function retrieve_active() {
        $user_id = $this->session->userdata('user_id');
        $current = date( 'Y-m-d H:i:s', strtotime('today midnight') );
        $conditions = "`start`>'".$current."'";
        $rides = $this->ride->retrieve( $conditions );
        

        // Use ride ID as the index key
        $temp_rides = array();
        foreach( $rides as $ride ) { 
            $temp_rides[$ride->id] = $ride;

            if ( $ride->drop_offs == '' ) {
                $temp_rides[$ride->id]->drop_offs = array() ;
            } else {
                $temp_rides[$ride->id]->drop_offs = explode(WHEELZO_DELIMITER, $ride->drop_offs) ; 
            }
         
            $temp_rides[$ride->id]->passengers = $this->user_ride->retrieve(
                array(
                    'ride_id' => $ride->id 
                )
            );

            $temp_rides[$ride->id]->comments = $this->comment->retrieve(
                array(
                    'ride_id' => $ride->id 
                )
            );

            if ( $ride->driver_id == $user_id ) {
                $temp_rides[$ride->id]->is_personal = true;
            } else {
                foreach ( $temp_rides[$ride->id]->passengers as $passenger ) {
                    if ($passenger->user_id == $user_id ) {
                        $temp_rides[$ride->id]->is_personal = true;
                        break;
                    }
                }
            }

            if ( !isset($temp_rides[$ride->id]->is_personal) ) {
                $temp_rides[$ride->id]->is_personal = false;
            }
        }

        return $temp_rides;
    }

    function retrieve_personal() {
        $user_id = $this->session->userdata('user_id');
        if ( $user_id ) {
            $conditions = '`driver_id` = '.$user_id;

            $passenger_of_rides = $this->user_ride->retrieve_ride_id(
                array(
                    'user_id' => $user_id
                )
            );

            foreach ( $passenger_of_rides as $mapping ) {
                $conditions .= " OR `id` = ".$mapping->ride_id;
            }

            $rides = $this->ride->retrieve($conditions);
            
            // Use ride ID as the index key
            $temp_rides = array();
            foreach( $rides as $ride ) { 
                $temp_rides[$ride->id] = $ride; 
                $temp_rides[$ride->id]->is_personal = true;
                if ( $ride->drop_offs == '' ) {
                    $temp_rides[$ride->id]->drop_offs = array() ;
                } else {
                    $temp_rides[$ride->id]->drop_offs = explode(WHEELZO_DELIMITER, $ride->drop_offs) ; 
                }
             
                $temp_rides[$ride->id]->passengers = $this->user_ride->retrieve(
                    array(
                        'ride_id' => $ride->id 
                    )
                );

                $temp_rides[$ride->id]->comments = $this->comment->retrieve(
                    array(
                        'ride_id' => $ride->id 
                    )
                );
            }
            
            return $temp_rides;        
        
        } else {
            return array();
        }
    }

    function retrieve_by_id( $id = 0 ) {
        $objects = $this->ride->retrieve(
            array(
                'id' => $id
            )
        );

        if ( count($objects) > 0 ) {
            return $objects[0];
        } else {
            return false;
        }
    }

    // BEGIN BASIC CRUD FUNCTIONALITY

    function create( $data = array() ){
        $this->db->insert('ride', $data);    
        return $this->db->insert_id();
    }

    function retrieve( $data = array() ){
        $this->db->where($data);
        $query = $this->db->get('ride');
        return $query->result();
    }
    
    function update( $criteria = array(), $new_data = array() ){
        $this->db->where($criteria);
        $this->db->update('ride', $new_data);
    }
    
    function delete( $data = array() ){
        $this->db->where($data);
        $this->db->delete('ride');
    }

}

?>