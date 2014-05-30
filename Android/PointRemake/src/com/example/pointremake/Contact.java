package com.example.pointremake;

public class Contact {
	
	//private variables
	String _cardid;
	String _shopid;
	String _point;
	// Empty constructor
	public Contact(){
		
	}
	// constructor
//	public Contact(int id, String cardid, String shopid , String point , String status){
//		this._cardid = cardid;
//		this._shopid = shopid;
//		this._point = point;
//		this._status = status;
//	}
	
	// constructor
	public Contact(String cardid, String shopid,String point){
		this._cardid = cardid;
		this._shopid = shopid;
		this._point = point;
	}

	// getting cardid
	public String getCardid(){
		return this._cardid;
	}
	
	// setting cardid
	public void setCardid(String cardid){
		this._cardid = cardid;
	}
	
	// getting phone number
	public String getPoint(){
		return this._point;
	}
	
	// setting phone number
	public void setPoint(String point){
		this._point = point;
	}
	
	public String getShopid(){
		return this._shopid;
	}
	
	public void setShopid(String shopid){
		this._shopid = shopid;
	}
	
	

	
}
