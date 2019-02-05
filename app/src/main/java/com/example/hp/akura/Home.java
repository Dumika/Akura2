package com.example.hp.akura;

import android.content.Intent;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.view.MenuItem;
import android.view.View;

public class Home extends AppCompatActivity {
    CardView cardHardAsset, cardSoftAsset, cardMaintenance, cardReservation;
//    private ActionBarDrawerToggle mToggle;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

//        if (!SharedPrefManager.getInstance(this).isLoggedIn()) {
//            finish();
//            startActivity(new Intent(this, Login.class));
//        }

        setContentView(R.layout.activity_home);
//
//        DrawerLayout mDrawerLayout = (DrawerLayout) findViewById(R.id.activity_main);
//        mToggle=new ActionBarDrawerToggle(this, mDrawerLayout,R.string.open,R.string.close);
//        mDrawerLayout.addDrawerListener(mToggle);
//        mToggle.syncState();
//        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        cardHardAsset = findViewById(R.id.card_hard_asset);
        cardSoftAsset = findViewById(R.id.card_soft_asset);
        cardMaintenance = findViewById(R.id.card_maintenance);
        cardReservation = findViewById(R.id.card_reservation);

        cardHardAsset.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(Home.this, HardAsset.class);
                startActivity(i);
            }
        });

        cardSoftAsset.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(Home.this, SoftAsset.class);
                startActivity(i);
            }
        });

        cardMaintenance.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(Home.this, Maintenance.class);
                startActivity(i);
            }
        });

        cardReservation.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(Home.this, Reservation.class);
                startActivity(i);
            }
        });
    }

//    @Override
//    public boolean onOptionsItemSelected(MenuItem item) {
//        if(mToggle.onOptionsItemSelected(item)){
//            return true;
//        }
//        return super.onOptionsItemSelected(item);
//    }
}
