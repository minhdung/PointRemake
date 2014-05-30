package com.example.pointremake;

import java.util.List;

import org.json.JSONException;
//import org.json.JSONException;
import org.json.JSONObject;

import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.example.pointremake.Contact;
import com.example.pointremake.R;

import android.support.v4.app.Fragment;
import android.annotation.SuppressLint;
import android.app.ActivityOptions;
import android.app.PendingIntent;
import android.content.Intent;

import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.os.Handler;
import android.os.Parcelable;
import android.util.Log;
import android.view.KeyEvent;
//import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;
import android.nfc.Tag;
import android.nfc.NdefMessage;
import android.nfc.NdefRecord;
import android.app.Activity;

@SuppressLint("NewApi")
public class MainActivity extends Activity {
	private NfcAdapter mNfcAdapter;
	private PendingIntent mPendingIntent;
	private String cardid;
	private String shopid = "2";
	private String mypoint;
	private boolean ressuccess = false;
	int point;
	
	TextView text;
	DatabaseHandler db = new DatabaseHandler(this);

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		Log.d("log", "create");
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		// text = (TextView) findViewById(R.id.textView1);
		
		//効果音


		//APIのURL設定
		String url = "http://10.10.8.103/PointRemake/Server/Clerks/addcard?card_name="
				+ cardid;
		RequestQueue queue = Volley.newRequestQueue(this);
		JsonObjectRequest jsObjRequest = new JsonObjectRequest(
				Request.Method.GET, url, null,
				new Response.Listener<JSONObject>() {

					@Override
					public void onResponse(JSONObject response) {

						try {
							if (db.newcontactlogs() != null) {

								updatelogs(db.newcontactlogs());

							}
						} catch (Exception e) {

							text.setText(e.getMessage());
						}

					}

				}, new Response.ErrorListener() {

					@Override
					public void onErrorResponse(VolleyError error) {

					}
				}) {

		};

		jsObjRequest.setRetryPolicy(new DefaultRetryPolicy(20 * 1000, 1, 1.0f));
		queue.add(jsObjRequest);

		try {
			String log = "";
			List<Contact> contacts = db.getAllContacts();
			for (Contact cn : contacts) {
				log += "carid: " + cn.getCardid() + " ,Point: " + cn.getPoint();
				// Writing Contacts to log

			}
			Log.d("Contact: ", log);
		} catch (Exception e) {
			text.setText(e.getMessage());
		}

//		try {
//			String contaclog = "";
//			List<Contactlogs> contacts = db.getAllContactslogs();
//
//			for (Contactlogs cn : contacts) {
//				contaclog += "Id: " + cn.getID() + " ,carid: " + cn.getCardid()
//						+ " ,Point: " + cn.getPoint() + "status"
//						+ cn.getStatus();
//				// Writing Contacts to log
//
//			}
//			//Log.d("Contact Logs: ", contaclog);
//		} catch (Exception e) {
//			text.setText(e.getMessage());		//例外
//		}

		//NFC 信号取得
		mNfcAdapter = NfcAdapter.getDefaultAdapter(this);
		if (mNfcAdapter == null) {
			// NFC　がサポートされない
			Toast.makeText(this, "This device doesn't support NFC.",
					Toast.LENGTH_LONG).show();
			finish();
			return;
		}
		mPendingIntent = PendingIntent.getActivity(this, 0, new Intent(this,
				getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), 0);
		handleIntent(getIntent());
		// Log.d("acd", handleIntent(getIntent()));
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (android.os.Build.VERSION.SDK_INT < android.os.Build.VERSION_CODES.ECLAIR
				&& (keyCode == KeyEvent.KEYCODE_BACK || keyCode == KeyEvent.KEYCODE_HOME)
				&& event.getRepeatCount() == 0) {
			onBackPressed();
		}
		return super.onKeyDown(keyCode, event);
	}

	@Override
	public void onBackPressed() {
		// Do nothing
		return;
	}

	@Override
	protected void onResume() {
				Log.d("log", "resume");
		super.onResume();


		if (mNfcAdapter != null) {
			mNfcAdapter.enableForegroundDispatch(this, mPendingIntent, null,
					null);



		}
		//Declared handler
		new Handler().postDelayed(new Runnable() {
			@Override
			public void run() {
				imageTouch();
			}
		}, 1500);

		//
		// Log.d("cardid",cardid);
		// Log.d("ressuccess",ressuc);

	}

	@Override
	protected void onPause() {
		Log.d("log", "onPause");
		super.onPause();
		if (mNfcAdapter != null) {
			mNfcAdapter.disableForegroundDispatch(this);
		}
	}

	@Override
	protected void onNewIntent(Intent intent) {
		setIntent(intent);
		handleIntent(intent);
	}

	/**
	 * ＮＦＣカードのＩＤ取得処理
	 * @param intent
	 */
	private void handleIntent(Intent intent) {
		Log.d("log", "handleIntent");
		String action = intent.getAction();
		if (NfcAdapter.ACTION_TAG_DISCOVERED.equals(action)
				|| NfcAdapter.ACTION_TECH_DISCOVERED.equals(action)
				|| NfcAdapter.ACTION_NDEF_DISCOVERED.equals(action)) {
			Parcelable[] rawMsgs = intent
					.getParcelableArrayExtra(NfcAdapter.EXTRA_NDEF_MESSAGES);
			NdefMessage[] msgs;
			if (rawMsgs != null) {
				msgs = new NdefMessage[rawMsgs.length];
				for (int i = 0; i < rawMsgs.length; i++) {
					msgs[i] = (NdefMessage) rawMsgs[i];
				}
			} else {
				// タグのタイプが知らない
				byte[] empty = new byte[0];
				byte[] id = intent.getByteArrayExtra(NfcAdapter.EXTRA_ID);
				Parcelable tag = intent
						.getParcelableExtra(NfcAdapter.EXTRA_TAG);
				byte[] payload = dumpTagData(tag).getBytes();
				NdefRecord record = new NdefRecord(NdefRecord.TNF_UNKNOWN,
						empty, id, payload);
				NdefMessage msg = new NdefMessage(new NdefRecord[] { record });
				msgs = new NdefMessage[] { msg };
			}


		}
	}

	/**
	 * ＡＰＩからデータ取得
	 * @param p
	 * @return
	 */
	private String dumpTagData(Parcelable p) {
		Log.d("log", "dumpTagData");
		StringBuilder sb = new StringBuilder();
		Tag tag = (Tag) p;
		byte[] id = tag.getId();
		sb.append(getReversed(id));
		
		//カードのＩＤ取得
		cardid = sb.toString();
		if (cardid != null) {

			String url = "http://10.10.8.103/PointRemake/Server/Clerks/addcard?card_name="
					+ cardid;
			RequestQueue queue = Volley.newRequestQueue(this);
			JsonObjectRequest jsObjRequest = new JsonObjectRequest(
					Request.Method.GET, url, null,
					new Response.Listener<JSONObject>() {

						@Override
						public void onResponse(JSONObject response) {

							String dbpoint = "0";
							try {
								dbpoint = response.getJSONObject("data")
										.getString("point");
								ressuccess = true;
							} catch (JSONException e) {
								// TODO Auto-generated catch block
								e.printStackTrace();
							}

							Contact resdb = db.getContact_bycardid(cardid);
							if (resdb != null) {

								resdb.setPoint(dbpoint);
								db.updateContact(resdb);
								mypoint = dbpoint;
							} else {
								db.addContact(new Contact(cardid, shopid,
										dbpoint));
								mypoint = dbpoint;
							}

						}

					}, new Response.ErrorListener() {

						@Override
						public void onErrorResponse(VolleyError error) {

							try {
								Contact contact = db
										.getContact_bycardid(cardid);
								if (contact != null) {
									mypoint = contact.getPoint();
								} else {
									mypoint = "0";
								}
								//Log.d("Success", "thanh cong");
								ressuccess = true;
							} catch (Exception e) {
								//Log.d("error", e.getMessage());
							}

						}
					}) {

			};

			jsObjRequest.setRetryPolicy(new DefaultRetryPolicy(90, 1,
					1.0f));
			queue.add(jsObjRequest);
		}
		return sb.toString();
	}

	private long getReversed(byte[] bytes) {
		Log.d("log", "getReversed");
		long result = 0;
		long factor = 1;
		for (int i = bytes.length - 1; i >= 0; --i) {
			long value = bytes[i] & 0xffl;
			result += value * factor;
			factor *= 256l;
		}
		return result;
	}

	public void imageTouch() {
		Log.d("imageTouch","imageTouch");
		// Call API get current Point
		// TODO

		// Go to next screen

		if (cardid != null && ressuccess) {
			
//			MediaPlayer mp = MediaPlayer.create(getApplicationContext(), R.raw.open);
//			mp.start();
			
			Intent intent = new Intent(MainActivity.this,
					ShowPointActivity.class);
			intent.putExtra("cardid", cardid);
			intent.putExtra("mypoint", mypoint);
			Bundle bndlanimation = 
					ActivityOptions.makeCustomAnimation(getApplicationContext(), R.anim.animation_left,R.anim.animation_right).toBundle();
			startActivity(intent, bndlanimation);
		}
	}

	public void updatelogs(List<Contactlogs> logs) {
		for (final Contactlogs cn : logs) {

			String url = "http://10.10.8.103/PointRemake/Server/Clerks/addcard?card_name="
					+ cn.getCardid() + "&point=" + cn.getPoint();
			RequestQueue queue = Volley.newRequestQueue(this);
			JsonObjectRequest jsObjRequest = new JsonObjectRequest(
					Request.Method.GET, url, null,
					new Response.Listener<JSONObject>() {

						@Override
						public void onResponse(JSONObject response) {

							cn.setStatus("updated");
							db.updateContact(cn);

						}

					}, new Response.ErrorListener() {

						@Override
						public void onErrorResponse(VolleyError error) {

						}
					}) {

			};

			// jsObjRequest.setRetryPolicy(new DefaultRetryPolicy(20 * 1000,
			// 1, 1.0f));
			queue.add(jsObjRequest);

		}

	}

	/**
	 * A placeholder fragment containing a simple view.
	 */
	public static class PlaceholderFragment extends Fragment {

		public PlaceholderFragment() {
		}

		@Override
		public View onCreateView(LayoutInflater inflater, ViewGroup container,
				Bundle savedInstanceState) {
			View rootView = inflater.inflate(R.layout.fragment_main, container,
					false);
			return rootView;
		}
	}


}
