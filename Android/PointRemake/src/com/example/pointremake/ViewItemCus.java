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
	//�A�j���[�V����
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
	
	
	//Gridlayout�̑�����ݒ�
	@SuppressWarnings("deprecation")
	public void setAtribute(boolean flag,int number ){
		mTvNumber.setText(number + "");
		mNumber = number;
		
		if( number % 5 == 0){
			// �v���[���g�̉摜���\��
			mImgvPresent.setVisibility(View.VISIBLE);
			mImgvPresent.setImageDrawable(mContext.getResources().getDrawable(R.drawable.icon_6m_128));
			mImgvPresent.setAlpha(90);

		}else{
			// �v���[���g�̉摜���\������Ȃ�
			mImgvPresent.setVisibility(View.GONE);
		}
		
		if(flag){
			
			// �`�F�b�N�̉摜���\��
			mImgvCup.setVisibility(View.VISIBLE);
			mImgvCup.setImageDrawable(mContext.getResources().getDrawable(R.drawable.check));
			gridlayoutItem.setBackgroundColor(Color.RED);

		}else{
			// �`�F�b�N�̉摜���\������Ȃ�
			mImgvCup.setVisibility(View.GONE);
			gridlayoutItem.setBackgroundColor(mContext.getResources().getColor(R.color.holo_orange_dark));

		}
	}
	
	/**
	 * �Y�[���C���ƃY�[���A�E�g�̃A�j���[�V����
	 * @param animation_flag
	 */
	public void  setAnimation(boolean animation_flag) {
		if(animation_flag){
			//�Y�[���C���A�j���[�V����
			mImgvCup.startAnimation(zoom_in_anime);
			mImgvCup.setVisibility(View.VISIBLE);
		}else{
			//�Y�[���A�E�g�A�j���[�V����
			mImgvCup.startAnimation(zoom_out_anime);
			mImgvCup.setVisibility(View.GONE);
		}
		
	}
	//�C���^�[�t�F�[�X����
	public interface  Select{
		public void selectItem(int number);
	}
	

}
