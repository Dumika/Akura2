package com.example.hp.akura;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class ItemListing extends AppCompatActivity {
    private ListView itemsListView;
    private ProgressDialog progressDialog;
    private JSONArray itemsList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_item_listing);

        itemsListView = findViewById(R.id.itemsList);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Loading items...");

        sendGetItemsRequest();

    }

    void updateList() {
        itemsListView.setAdapter(new ItemsListAdapter());
    }

    void sendGetItemsRequest() {
        progressDialog.show();
        DataRequester dataRequester = new DataRequester(
                ItemListing.this,
                Request.Method.GET,
                Constants.ITEMS_GET_URL,
                null,
                null
        );
        dataRequester.sendRequest(
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        progressDialog.dismiss();
                        try {
                            itemsList = response.getJSONArray("items");
                            updateList();
                        } catch (JSONException e) {
                            new AlertDialog.Builder(ItemListing.this)
                                    .setTitle("Error")
                                    .setMessage("Error parsing data.")
                                    .setNegativeButton(
                                            "Retry",
                                            new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialogInterface, int i) {
                                                    sendGetItemsRequest();
                                                }
                                            }
                                    )
                                    .show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        progressDialog.dismiss();
                        new AlertDialog.Builder(ItemListing.this)
                                .setTitle("Error")
                                .setMessage(error.toString())
                                .setNegativeButton(
                                        "Retry",
                                        new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialogInterface, int i) {
                                                sendGetItemsRequest();
                                            }
                                        }
                                )
                                .show();
                    }
                }
        );
    }

    void sendDeleteRequest(final String serialNo) {
//        try {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Deleting item...");
        progressDialog.show();

        StringRequest request = new StringRequest(
                Request.Method.POST,
                Constants.ITEM_DELETE_URL,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String strResponse) {
                        progressDialog.dismiss();
                        try {
                            JSONObject response = new JSONObject(strResponse);
                            Log.d("MY_APP", response.toString());
                            if (response.getInt("success") == 1) {
                                new AlertDialog.Builder(ItemListing.this)
                                        .setTitle("Success")
                                        .setMessage("Successfully deleted the item.")
                                        .setPositiveButton(
                                                "Close",
                                                new DialogInterface.OnClickListener() {
                                                    @Override
                                                    public void onClick(DialogInterface dialogInterface, int i) {
                                                        dialogInterface.dismiss();
                                                    }
                                                }
                                        ).show();
                                sendGetItemsRequest();
                            } else {
                                new AlertDialog.Builder(ItemListing.this)
                                        .setTitle("Error")
                                        .setMessage("Error deleting item\n" + response.getString("message"))
                                        .setPositiveButton(
                                                "Retry",
                                                new DialogInterface.OnClickListener() {
                                                    @Override
                                                    public void onClick(DialogInterface dialogInterface, int i) {
                                                        sendDeleteRequest(serialNo);
                                                    }
                                                }
                                        ).show();
                            }
                        } catch (JSONException e) {
                            new AlertDialog.Builder(ItemListing.this)
                                    .setTitle("Error")
                                    .setMessage("Error deleting item\nError parsing data")
                                    .setPositiveButton(
                                            "Retry",
                                            new DialogInterface.OnClickListener() {
                                                @Override
                                                public void onClick(DialogInterface dialogInterface, int i) {
                                                    sendDeleteRequest(serialNo);
                                                }
                                            }
                                    )
                                    .show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        progressDialog.dismiss();
                        new AlertDialog.Builder(ItemListing.this)
                                .setTitle("Error")
                                .setMessage("Error deleting item\n" + error.toString())
                                .setPositiveButton(
                                        "Retry",
                                        new DialogInterface.OnClickListener() {
                                            @Override
                                            public void onClick(DialogInterface dialogInterface, int i) {
                                                sendDeleteRequest(serialNo);
                                            }
                                        }
                                ).show();
                    }
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> map = new HashMap<>();
                map.put("SerialNo", serialNo);
                return map;
            }
        };

        Volley.newRequestQueue(this).add(request);
    }

    class ItemsListAdapter extends BaseAdapter {
        @Override
        public int getCount() {
            if (itemsList != null) {
                return itemsList.length();
            }
            return 0;
        }

        @Override
        public JSONObject getItem(int i) {
            if (itemsList != null) {
                try {
                    return itemsList.getJSONObject(i);
                } catch (JSONException ignore) {
                }
            }
            return null;
        }

        @Override
        public long getItemId(int i) {
            return i;
        }

        @Override
        public View getView(final int i, View view, ViewGroup viewGroup) {
            if (view == null) {
                view = getLayoutInflater().inflate(R.layout.hard_asset_list_item, viewGroup, false);
                TextView serial_no = view.findViewById(R.id.serial_no);
                TextView type = view.findViewById(R.id.type);
                TextView section = view.findViewById(R.id.section);
                TextView person_in_charge = view.findViewById(R.id.person_in_charge);
                TextView quantity = view.findViewById(R.id.quantity);
                TextView supplier = view.findViewById(R.id.supplier);

                Button deleteBtn = view.findViewById(R.id.button_delete);
                Button editBtn = view.findViewById(R.id.button_edit);

                try {
                    final String s_serial_no = getItem(i).getString("SerialNo");
                    final String s_type = getItem(i).getString("Type");
                    final String s_section = getItem(i).getString("Section");
                    final String s_person_in_charge = getItem(i).getString("PersonInCharge");
                    final String s_quantity = getItem(i).getString("Quantity");
                    final String s_supplier = getItem(i).getString("Supplier");

                    serial_no.setText(String.format("Serial No : %s", s_serial_no));
                    type.setText(String.format("Type : %s", s_type));
                    section.setText(String.format("Section : %s", s_section));
                    person_in_charge.setText(String.format("Person in charge : %s", s_person_in_charge));
                    quantity.setText(String.format("Quantity : %s", s_quantity));
                    supplier.setText(String.format("Supplier : %s", s_supplier));

                    deleteBtn.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            try {
                                sendDeleteRequest(getItem(i).getString("SerialNo"));
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                    });
                    editBtn.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            Intent intent = new Intent(ItemListing.this, ItemUpdate.class);
                            intent.putExtra("serial_no", s_serial_no);
                            intent.putExtra("type", s_type);
                            intent.putExtra("section", s_section);
                            intent.putExtra("person_in_charge", s_person_in_charge);
                            intent.putExtra("quantity", s_quantity);
                            intent.putExtra("supplier", s_supplier);

                            startActivityForResult(intent, 0);
                        }
                    });
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
            return view;
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        if (resultCode == RESULT_OK) {
            sendGetItemsRequest();
        }
        super.onActivityResult(requestCode, resultCode, data);
    }
}
