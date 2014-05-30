package com.example.pointremake;

public class Contactlogs {
	
	//private variables
	int _id;
	String _cardid;
	String _shopid;
	String _point;
	String _status;
	// Empty constructor
	public Contactlogs(){
		
	}
	// constructor
	public Contactlogs(int id, String cardid, String shopid , String point , String status){
		this._id = id;
		this._cardid = cardid;
		this._shopid = shopid;
		this._point = point;
		this._status = status;
	}
	
	// constructor
	public Contactlogs(String cardid, String shopid,String point , String status){
		this._cardid = cardid;
		this._shopid = shopid;
		this._point = point;
		this._status = status;
	}
	// getting ID
	public int getID(){
		return this._id;
	}
	
	// setting id
	public void setID(int id){
		this._id = id;
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
	
	public String getStatus(){
		return this._status;
	}
	
	public void setStatus(String status){
		this._status = status;
	}
	

	
}
