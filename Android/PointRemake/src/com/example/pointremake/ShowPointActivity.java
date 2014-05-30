package com.example.pointremake;

//import java.text.SimpleDateFormat;
//import java.util.Calendar;
//import java.util.List;

//import org.json.JSONException;
import java.util.List;

import org.json.JSONObject;

import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.example.pointremake.Contactlogs;
import com.example.pointremake.R;
import com.example.pointremake.ViewItemCus.Select;

import android.support.v7.app.ActionBarActivity;
import android.support.v4.app.Fragment;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.Dialog;
import android.content.Intent;
import android.graphics.Color;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.media.SoundPool;
import android.media.SoundPool.OnLoadCompleteListener;
import android.os.Bundle;
import android.os.Handler;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.view.animation.Animation.AnimationListener;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.Button;
import android.widget.GridLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

@SuppressWarnings("unused")
public class ShowPointActivity extends Activity implements Select, AnimationListener {
	GridLayout gridLayout;
	private int width = 0;
	private int COLUMS_NUMBER = 5;
	private int NUMBER_OF_ITEM = 15;		//セールの数
	String cardid;							//ＮＦＣカードのＩＤ
	String shopid = "2";					//ショップのＩＤ
	int point;
	String mypoint;
	private int rate = 50;					// stamp = point / rate
	private int stamp;  					//ユーザーのスタンプ
	private int step;
	private int stepnumber;
	private int addstamp;
	private int currentStamp;
	private int currentPosition;
	TextView text;
	private TextView textView2;
	private TextView pointNumber;
	private TextView text_view_card_id;
	//インスタンス作成
	private SoundPool sp ;       
	private int sound_id;
	private int sound_open;
	private SoundPool sp_open ;       
	
	
	Animation animZoomIn;
	DatabaseHandler db = new DatabaseHandler(this);
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		Log.d("ShowPointActivity","ShowPointActivity");
		
		super.onCreate(savedInstanceState);
		//レイアウトを設定
		setContentView(R.layout.activity_show_point);
	
//		MediaPlayer mp = MediaPlayer.create(getApplicationContext(), R.raw.open);
//		mp.start();
		//レイアウトの要素取得
		textView2 = (TextView) findViewById(R.id.textView2);
		text_view_card_id = (TextView) findViewById(R.id.text_view_card_id);
		pointNumber = (TextView) findViewById(R.id.point_number);
		
		//効果音
		sp = new SoundPool( 1, AudioManager.STREAM_MUSIC, 0 );
		sound_id = sp.load(this, R.raw.stamp, 1 );
		sp_open = new SoundPool( 2, AudioManager.STREAM_MUSIC, 0 );
		sound_open = sp_open.load(this, R.raw.open, 1 );
//		sp_open.play(sound_open, 40, 40, 1, 0, 1f);
		sp_open.setOnLoadCompleteListener(new OnLoadCompleteListener() {
            @Override
            public void onLoadComplete(SoundPool soundPool, int sampleId,
                    int status) {
            	sp_open.play(sound_open, 40, 40, 1, 0, 1f);
            }
        });
    
		// アニメーションをロードする
		animZoomIn = AnimationUtils.loadAnimation(getApplicationContext(),R.anim.zoom_in);
		// set animation listener
		animZoomIn.setAnimationListener(this);
		if (getIntent() != null) {
			cardid = getIntent().getExtras().getString("cardid");
			mypoint = getIntent().getExtras().getString("mypoint");
			if (mypoint != "0") {
				point = Integer.valueOf(mypoint);
			} else {
				point = 0;
			}
			stamp = point / rate;
			currentStamp = stamp % NUMBER_OF_ITEM;
			currentPosition = currentStamp;
			text_view_card_id.setText(cardid);
			pointNumber.setText("+0");

			gridLayout = (GridLayout) findViewById(R.id.gridView1);
			
			// calculate item
			DisplayMetrics metrics = this.getResources().getDisplayMetrics();
			this.getWindowManager().getDefaultDisplay().getMetrics(metrics);
			width = metrics.widthPixels - 30;
			gridLayout.setColumnCount(COLUMS_NUMBER);
			for (int i = 1; i <= NUMBER_OF_ITEM; i++) {
				addView(i);
			}
			
			
			step = stamp / NUMBER_OF_ITEM;
			if (step < 1) {
				for (int i = 0; i < stamp; i++) {
					
					ViewItemCus view = (ViewItemCus) gridLayout.getChildAt(i);
					view.setAtribute(true, i + 1);
				}
			} else {
				for (int i = 0; i < (stamp - (step * NUMBER_OF_ITEM)); i++) {
					ViewItemCus view = (ViewItemCus) gridLayout.getChildAt(i);
					view.setAtribute(true, i + 1);
				}
			}
		}

	}
	


	@SuppressLint("NewApi")
	public void addView(int number) {
		ViewItemCus item = new ViewItemCus(this);
		item.setAtribute(false, number);
		gridLayout.addView(item, width / 5, width / 5);
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
		Intent intent = new Intent(ShowPointActivity.this,
				MainActivity.class);
		startActivity(intent);
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
			View rootView = inflater.inflate(R.layout.fragment_show_point,
					container, false);
			return rootView;
		}
	}

	/**
	 * Show present or notice pop　up
	 * @param v
	 */
	public void showPopup(View v) {	
		if (addstamp > stamp) {
			// APIのＵＲＬ設定
			String url = "http://10.10.8.103/PointRemake/Server/Clerks/addcard?card_name="
					+ cardid + "&point=" + (addstamp - stamp) * rate;
			RequestQueue queue = Volley.newRequestQueue(this);
			JsonObjectRequest jsObjRequest = new JsonObjectRequest(
					Request.Method.GET, url, null,
					new Response.Listener<JSONObject>() {

						@Override
						public void onResponse(JSONObject response) {

							Contact resdb = db.getContact_bycardid(cardid);
							int dbpoint = point + (addstamp - stamp) * rate;
							if (resdb != null) {
								resdb.setPoint(String.valueOf(dbpoint));
								db.updateContact(resdb);
							} else {
								db.addContact(new Contact(cardid, shopid,
										String.valueOf(dbpoint)));
							}
							db.addContactlogs(new Contactlogs(cardid, shopid,
									String.valueOf((addstamp - stamp) * rate),
									"updated"));

						}

					}, new Response.ErrorListener() {

						@Override
						public void onErrorResponse(VolleyError error) {

							Contact resdb = db.getContact_bycardid(cardid);
							int dbpoint = point + (addstamp - stamp) * rate;

							if (resdb != null) {
								resdb.setPoint(String.valueOf(dbpoint));
								db.updateContact(resdb);
							} else {

								try {
									db.addContact(new Contact(cardid, shopid,
											String.valueOf(dbpoint)));
									//Log.d("log show point", cardid + "   "
									//		+ shopid);
								} catch (Exception e) {
									//例外取得
									System.err.println("エラー" + e.getMessage());
								}
							}
							db.addContactlogs(new Contactlogs(cardid, shopid,
									String.valueOf((addstamp - stamp) * rate),
									"new"));

						}
					}) {

			};

			jsObjRequest.setRetryPolicy(new DefaultRetryPolicy(100, 1,
					1.0f));

			queue.add(jsObjRequest);

			//ダイアログ初期
			final Dialog dialog = new Dialog(this);
			dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
			stepnumber = stamp / COLUMS_NUMBER;
			if ((addstamp - (stepnumber * COLUMS_NUMBER)) / COLUMS_NUMBER >= 1) {
				//プレゼントの効果音を追加する
				MediaPlayer mp = MediaPlayer.create(getApplicationContext(), R.raw.gift);
				mp.start();
				stepnumber = stamp / NUMBER_OF_ITEM;
				dialog.setContentView(R.layout.dialog_custom);
				dialog.setCancelable(false);
				dialog.setCanceledOnTouchOutside(false);
				ImageView img = (ImageView) dialog
						.findViewById(R.id.popup_image);
				TextView dialogText = (TextView) dialog
						.findViewById(R.id.present_description);
				if (((addstamp - (stepnumber * NUMBER_OF_ITEM)) / COLUMS_NUMBER) < 2) {					
					img.setImageResource(R.drawable.gift01);
					dialogText.setText("プレゼント1");
				} else {
					if (((addstamp - (stepnumber * NUMBER_OF_ITEM)) / COLUMS_NUMBER) < 3) {
						img.setImageResource(R.drawable.gift02);
						dialogText.setText("プレゼント2");
					} else {
						img.setImageResource(R.drawable.gift03);
						dialogText.setText("プレゼント3");
					}
				}
			} else {
				//報告の効果音を追加する
				MediaPlayer mp = MediaPlayer.create(getApplicationContext(), R.raw.nogift);
				mp.start();
				
				//ダイアログのレイアウトを設定
				dialog.setContentView(R.layout.dialog_report);
				dialog.setCancelable(false);
				dialog.setCanceledOnTouchOutside(false);
				TextView dialogText = (TextView) dialog
						.findViewById(R.id.report_point);

				dialogText
						.setText((COLUMS_NUMBER - (addstamp - (stepnumber * COLUMS_NUMBER)))
								+ "");

			}
			
			//ダイアログのアニメションロード
			dialog.getWindow().getAttributes().windowAnimations = R.style.DialogAnimation;
			LinearLayout dialogButton = (LinearLayout) dialog
					.findViewById(R.id.ok_button);
			dialogButton.setOnClickListener(new OnClickListener() {

				@Override
				public void onClick(View v) {
					// TODO Auto-generated method stub
					dialog.dismiss();
					Intent intent = new Intent(ShowPointActivity.this,
							MainActivity.class);
					startActivity(intent);
				}
			});
			//ダイアログ表示
			dialog.show();

			try {
				String log = "";
				List<Contact> contacts = db.getAllContacts();
				for (Contact cn : contacts) {
					log += "carid: " + cn.getCardid() + " ,Point: "
							+ cn.getPoint();
					// 連絡のログを書く

				}
//				Log.d("Contact: ", log);
			} catch (Exception e) {
				//例外を捕る
				text.setText(e.getMessage());
			}

			try {
				String contaclog = "";
				List<Contactlogs> contacts = db.getAllContactslogs();

				for (Contactlogs cn : contacts) {
					contaclog += "Id: " + cn.getID() + " ,carid: "
							+ cn.getCardid() + " ,Point: " + cn.getPoint()
							+ "status" + cn.getStatus();
					// 連絡のログを書く

				}
//				Log.d("Contact Logs: ", contaclog);
			} catch (Exception e) {
				//例外を捕る
				text.setText(e.getMessage());
			}
		}
	}

	/**
	 * セール選択
	 */
	@SuppressLint("NewApi")
	public void selectItem(int number) {
		//画面にタッチする時、TextView2がいなくなった
		textView2.setVisibility(View.GONE);
		addstamp = number;
		
		//効果音を追加
//		MediaPlayer mp = MediaPlayer.create(getApplicationContext(), R.raw.stamp);
//		mp.start();
		sp.play(sound_id, 1, 1, 0, 0, 1);

			
			if (addstamp > currentStamp) {
				pointNumber.setText("+" + (addstamp - currentStamp));
			}else{
				pointNumber.setText("+0");
			}
			if (number > currentStamp) {
				if(number > currentPosition){
					for (int i = currentPosition ; i < number; i++) {
						ViewItemCus view = (ViewItemCus) gridLayout.getChildAt(i);
						view.setAtribute(true, i + 1);
						view.setAnimation(true);
					}
				}else{
					for (int i = number; i < NUMBER_OF_ITEM; i++) {
						ViewItemCus view = (ViewItemCus) gridLayout.getChildAt(i);
						view.setAtribute(false, i + 1);
						if(i < currentPosition){
							view.setAnimation(false);
						}
					}
				}
			}else{
				if(currentPosition > currentStamp){
					for (int i = currentStamp; i < currentPosition; i++) {
						ViewItemCus view = (ViewItemCus) gridLayout.getChildAt(i);
						view.setAtribute(false, i + 1);
						view.setAnimation(false);
					}
				}
				
			}

		if(number > currentStamp){
			currentPosition = number;
		}else{
			currentPosition = currentStamp;
		}
		
		stamp = stamp % NUMBER_OF_ITEM;
		
	}

	@Override
	public void onAnimationEnd(Animation animation) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onAnimationRepeat(Animation animation) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onAnimationStart(Animation animation) {
		// TODO Auto-generated method stub
		
	}

}
