package com.example.hp.akura;

import android.app.ProgressDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class GenRes extends AppCompatActivity implements View.OnClickListener {
    private EditText editTextName, editTextAType, editTextStart, editTextEnd, editTextQuantity, editTextGrade, editTextPeriod;
    private Button buttonAdd;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_gen_res);
        editTextName = (EditText) findViewById(R.id.editTextName);
        editTextAType = (EditText) findViewById(R.id.editTextAType);
        editTextStart = (EditText) findViewById(R.id.editTextStart);
        editTextEnd = (EditText) findViewById(R.id.editTextEnd);
        editTextQuantity = (EditText) findViewById(R.id.editTextQuantity);
        editTextGrade = (EditText) findViewById(R.id.editTextGrade);
        editTextPeriod = (EditText) findViewById(R.id.editTextPeriod);

        buttonAdd = (Button) findViewById(R.id.buttonAdd);

        progressDialog = new ProgressDialog(this);

        buttonAdd.setOnClickListener(this);
    }

    private void registerUser() {
        final String Name = editTextName.getText().toString().trim();
        final String AType = editTextAType.getText().toString().trim();
        final String Start = editTextStart.getText().toString().trim();
        final String End = editTextEnd.getText().toString().trim();
        final String Quantity = editTextQuantity.getText().toString().trim();
        final String Grade = editTextGrade.getText().toString().trim();
        final String Period = editTextPeriod.getText().toString().trim();

        progressDialog.setMessage("Make Reservation...");
        progressDialog.show();

        StringRequest stringRequest=new StringRequest(Request.Method.POST,
                Constants.GEN_RES_URL,
                new Response.Listener <String>() {

                    @Override
                    public void onResponse(String response) {
                        progressDialog.dismiss();
                        // String array=response.substring(13);
                        try {
                            JSONObject jsonObject = new JSONObject(response);

                            Toast.makeText(getApplicationContext(), jsonObject.getString("message"), Toast.LENGTH_LONG).show();

                        } catch (JSONException e) {

                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        progressDialog.hide();
                        Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_LONG).show();

                    }
                }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("Name", Name);
                params.put("AType", AType);
                params.put("Start", Start);
                params.put("End", End);
                params.put("Quantity", Quantity);
                params.put("Grade", Grade);
                params.put("Period", Period);

                return params;
            }
        };

//        RequestQueue requestQueue=Volley.newRequestQueue(this);
//        requestQueue.add(stringRequest);
        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
    }

    @Override
    public void onClick(View view) {
        if (view == buttonAdd)
            registerUser();

    }


}