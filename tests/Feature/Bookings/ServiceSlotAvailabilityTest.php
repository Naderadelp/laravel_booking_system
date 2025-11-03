<?php

it('List correct employee availability', function () {
    $response = $this->get('/bookings//serviceslotavailability');

    $response->assertStatus(200);
});
