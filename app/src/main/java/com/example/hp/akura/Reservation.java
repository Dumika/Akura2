package com.example.hp.akura;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.view.View;

public class Reservation extends AppCompatActivity {
    CardView cardGenRes, cardAuthRes;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reservation);

        cardGenRes = findViewById(R.id.card_gen);
        cardAuthRes = findViewById(R.id.card_auth);

        cardGenRes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(Reservation.this, GenRes.class);
                startActivity(i);
            }
        });

        cardAuthRes.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(Reservation.this, AuthRes.class);
                startActivity(i);
            }
        });
    }
}
