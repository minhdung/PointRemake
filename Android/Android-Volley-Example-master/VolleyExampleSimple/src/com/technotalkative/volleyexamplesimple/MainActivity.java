package com.technotalkative.volleyexamplesimple;

import org.json.JSONObject;

import android.app.Activity;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

public class MainActivity extends Activity {

	private TextView txtDisplay;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		
		txtDisplay = (TextView) findViewById(R.id.txtDisplay);
		
		RequestQueue queue1 = Volley.newRequestQueue(this);
		String url = "https://www.googleapis.com/customsearch/v1?key=AIzaSyBmSXUzVZBKQv9FJkTpZXn0dObKgEQOIFU&cx=014099860786446192319:t5mr0xnusiy&q=AndroidDev&alt=json&searchType=image";
		
		JsonObjectRequest jsObjRequest = new JsonObjectRequest(Request.Method.GET, url, null, new Response.Listener<JSONObject>() {

			@Override
			public void onResponse(JSONObject response) {
				// TODO Auto-generated method stub
				txtDisplay.setText("Response => "+response.toString());
				findViewById(R.id.progressBar1).setVisibility(View.GONE);
			}
		}, new Response.ErrorListener() {

			@Override
			public void onErrorResponse(VolleyError error) {
				// TODO Auto-generated method stub
				
			}
		});
		
		queue1.add(jsObjRequest);
		
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

}
