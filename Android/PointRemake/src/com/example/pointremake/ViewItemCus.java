package com.example.pointremake;

import com.example.pointremake.R;

import android.content.Context;
import android.graphics.Color;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class ViewItemCus extends RelativeLayout{
	private TextView mTvNumber;
	private ImageView mImgvPresent;					//present image
	private ImageView mImgvCup;						// checked image
	private Context mContext;
	private RelativeLayout gridlayoutItem;
	private int mNumber;
	//アニメーション
	Animation zoom_in_anime;
	Animation zoom_out_anime;
	
	//Constructor
	public ViewItemCus(Context context) {
		super(context);
		mContext = context;
		init();
	}
	
	public ViewItemCus(Context context, AttributeSet attr){
		super(context, attr);
		mContext = context;
		init();
	}
	
	//Initial
	public void init(){
		LayoutInflater inflate = (LayoutInflater)mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		View view = inflate.inflate(R.layout.item_show_point,this,false);
		mTvNumber = (TextView)view.findViewById(R.id.tvTextId);
		mImgvPresent = (ImageView)view.findViewById(R.id.imgvPresentId);
		mImgvCup = (ImageView)view.findViewById(R.id.imgvCupId);
		gridlayoutItem = (RelativeLayout) view.findViewById(R.id.gridlayout_item);
		zoom_in_anime = AnimationUtils.loadAnimation(mContext, R.anim.zoom_in);
		zoom_out_anime = AnimationUtils.loadAnimation(mContext, R.anim.zoom_out);
		// click a item 
		setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				((Select)mContext).selectItem(mNumber);
			}
		});
		addView(view);
	}
	
	
	//Gridlayoutの属性を設定
	@SuppressWarnings("deprecation")
	public void setAtribute(boolean flag,int number ){
		mTvNumber.setText(number + "");
		mNumber = number;
		
		if( number % 5 == 0){
			// プレゼントの画像が表示
			mImgvPresent.setVisibility(View.VISIBLE);
			mImgvPresent.setImageDrawable(mContext.getResources().getDrawable(R.drawable.icon_6m_128));
			mImgvPresent.setAlpha(90);

		}else{
			// プレゼントの画像が表示されない
			mImgvPresent.setVisibility(View.GONE);
		}
		
		if(flag){
			
			// チェックの画像が表示
			mImgvCup.setVisibility(View.VISIBLE);
			mImgvCup.setImageDrawable(mContext.getResources().getDrawable(R.drawable.check));
			gridlayoutItem.setBackgroundColor(Color.RED);

		}else{
			// チェックの画像が表示されない
			mImgvCup.setVisibility(View.GONE);
			gridlayoutItem.setBackgroundColor(mContext.getResources().getColor(R.color.holo_orange_dark));

		}
	}
	
	/**
	 * ズームインとズームアウトのアニメーション
	 * @param animation_flag
	 */
	public void  setAnimation(boolean animation_flag) {
		if(animation_flag){
			//ズームインアニメーション
			mImgvCup.startAnimation(zoom_in_anime);
			mImgvCup.setVisibility(View.VISIBLE);
		}else{
			//ズームアウトアニメーション
			mImgvCup.startAnimation(zoom_out_anime);
			mImgvCup.setVisibility(View.GONE);
		}
		
	}
	//インターフェース初期
	public interface  Select{
		public void selectItem(int number);
	}
	

}
