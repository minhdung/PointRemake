package com.example.pointremake;

import java.util.ArrayList;
import java.util.List;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class DatabaseHandler extends SQLiteOpenHelper {

	// All Static variables
	// Database Version
	private static final int DATABASE_VERSION = 1;

	// Database Name
	private static final String DATABASE_NAME = "POINT_REMAKE";

	// Contacts table name
	private static final String TABLE_CONTACTS = "addcards";
	private static final String TABLE_CONTACTS_LOGS = "logs";
	// Contacts Table Columns names
	private static final String KEY_ID = "id";
	private static final String KEY_CARDID = "card_id";
	private static final String KEY_SHOPID = "shop_id";
	private static final String KEY_POINT = "point";
	private static final String KEY_STATUS = "status";
	public DatabaseHandler(Context context) {
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
	}

	// Creating Tables addcards
	@Override
	public void onCreate(SQLiteDatabase db) {
		String CREATE_CONTACTS_TABLE = "CREATE TABLE IF NOT EXISTS " + TABLE_CONTACTS + "(" +
				 KEY_CARDID + " TEXT PRIMARY KEY," + KEY_SHOPID + " TEXT,"
				+ KEY_POINT + " TEXT"+ ")";
		
		String CREATE_CONTACTS_TABLE_LOG = "CREATE TABLE IF NOT EXISTS " + TABLE_CONTACTS_LOGS + "("
				+ KEY_ID + " INTEGER PRIMARY KEY," + KEY_CARDID + " TEXT," + KEY_SHOPID + " TEXT,"
				+ KEY_POINT  + " TEXT,"+ KEY_STATUS + " TEXT"+ ")";
		
		db.execSQL(CREATE_CONTACTS_TABLE);
		db.execSQL(CREATE_CONTACTS_TABLE_LOG);}
		
	

	// Upgrading database
	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		// Drop older table if existed
		db.execSQL("DROP TABLE IF EXISTS " + TABLE_CONTACTS);
		db.execSQL("DROP TABLE IF EXISTS " + TABLE_CONTACTS_LOGS);
		// Create tables again
		onCreate(db);
	}

	/**
	 * All CRUD(Create, Read, Update, Delete) Operations
	 */

	// Adding new contact
	void addContact(Contact contact) {
		SQLiteDatabase db = this.getWritableDatabase();
		ContentValues values = new ContentValues();
		values.put(KEY_CARDID, contact.getCardid()); // Contact Card id
		values.put(KEY_SHOPID, contact.getShopid()); // Contact Shop id
		values.put(KEY_POINT, contact.getPoint()); // Contact Point
		// Inserting Row
		db.insert(TABLE_CONTACTS, null, values);
		db.close(); // Closing database connection
	}

	// Getting single contact
	Contact getContact(String cardid) {
		SQLiteDatabase db = this.getReadableDatabase();

		Cursor cursor = db.query(TABLE_CONTACTS, new String[] { 
				KEY_CARDID,KEY_SHOPID, KEY_POINT }, KEY_CARDID + "=?",
				new String[] { cardid }, null, null, null, null);
		if (cursor != null)
			cursor.moveToFirst();

		Contact contact = new Contact(
				cursor.getString(0),
				cursor.getString(1), 
				cursor.getString(2)
				);
		// return contact
		return contact;
	}
	
	Contact getContact_bycardid(String cardid) {
		SQLiteDatabase db = this.getReadableDatabase();

		Cursor cursor = db.query(TABLE_CONTACTS, new String[] { 
				KEY_CARDID,KEY_SHOPID, KEY_POINT }, KEY_CARDID + "=?",
				new String[] { cardid }, null, null, null, null);
		if (cursor.getCount() > 0)
		{
			cursor.moveToFirst();

		Contact contact = new Contact(
				cursor.getString(0),
				cursor.getString(1), 
				cursor.getString(2)
				);
		
		return contact;
		}
		
		else {
			return null;
		}
		
	}
	
	// Getting All Contacts
	public List<Contact> getAllContacts() {
		List<Contact> contactList = new ArrayList<Contact>();
		// Select All Query
		String selectQuery = "SELECT  * FROM " + TABLE_CONTACTS;

		SQLiteDatabase db = this.getWritableDatabase();
		Cursor cursor = db.rawQuery(selectQuery, null);

		// looping through all rows and adding to list
		if (cursor.moveToFirst()) {
			do {
				Contact contact = new Contact();
				contact.setCardid(cursor.getString(0));
				contact.setShopid(cursor.getString(1));
				contact.setPoint(cursor.getString(2));
//				contact.setCreate(cursor.getString(4));
//				contact.setUpdate(cursor.getString(5));
//				contact.setDelete(cursor.getString(6));
				// Adding contact to list
				contactList.add(contact);
			} while (cursor.moveToNext());
		}

		// return contact list
		return contactList;
	}

	// Updating single contact
	public int updateContact(Contact contact) {
		SQLiteDatabase db = this.getWritableDatabase();

		ContentValues values = new ContentValues();
		values.put(KEY_CARDID, contact.getCardid()); // Contact Card id
		values.put(KEY_SHOPID, contact.getCardid()); // Contact Shop id
		values.put(KEY_POINT, contact.getPoint()); // Contact Point
//		values.put(KEY_CREATE, contact.getCreate()); // Contact Create

		// updating row
		return db.update(TABLE_CONTACTS, values, KEY_CARDID + " = ?",
				new String[] { contact.getCardid()  });
	}

	// Deleting single contact
	public void deleteContact(Contact contact) {
		SQLiteDatabase db = this.getWritableDatabase();
		db.delete(TABLE_CONTACTS, KEY_CARDID + " = ?",
				new String[] { contact.getCardid() });
		db.close();
	}


	// Getting contacts Count
	public int getContactsCount() {
		String countQuery = "SELECT  * FROM " + TABLE_CONTACTS;
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.rawQuery(countQuery, null);
		cursor.close();

		// return count
		return cursor.getCount();
	}
	
	
	
	
	//table contact logs
	
	void addContactlogs(Contactlogs contact) {
		SQLiteDatabase db = this.getWritableDatabase();
		ContentValues values = new ContentValues();
		values.put(KEY_CARDID, contact.getCardid()); // Contact Card id
		values.put(KEY_SHOPID, contact.getShopid()); // Contact Shop id
		values.put(KEY_POINT, contact.getPoint()); // Contact Point
		values.put(KEY_STATUS, contact.getStatus()); // Contact Status
		// Inserting Row
		db.insert(TABLE_CONTACTS_LOGS, null, values);
		db.close(); // Closing database connection
	}

	// Getting single contact
	Contactlogs getContactlogs(int id) {
		SQLiteDatabase db = this.getReadableDatabase();

		Cursor cursor = db.query(TABLE_CONTACTS_LOGS, new String[] { KEY_ID,
				KEY_CARDID,KEY_SHOPID, KEY_POINT ,KEY_STATUS}, KEY_ID + "=?",
				new String[] { String.valueOf(id) }, null, null, null, null);
		if (cursor != null)
			cursor.moveToFirst();

		Contactlogs contact = new Contactlogs(
				Integer.parseInt(cursor.getString(0)),
				cursor.getString(1), 
				cursor.getString(2),
				cursor.getString(3),
				cursor.getString(4)
				);
		// return contact
		return contact;
	}
	
	Contactlogs getContact_bycardidlogs(String cardid) {
		SQLiteDatabase db = this.getReadableDatabase();

		Cursor cursor = db.query(TABLE_CONTACTS_LOGS, new String[] { KEY_ID,
				KEY_CARDID,KEY_SHOPID, KEY_POINT,KEY_STATUS}, KEY_CARDID + "=?",
				new String[] { cardid }, null, null, null, null);
		if (cursor.getCount() > 0)
			cursor.moveToFirst();

		Contactlogs contact = new Contactlogs(
				Integer.parseInt(cursor.getString(0)),
				cursor.getString(1), 
				cursor.getString(2),
				cursor.getString(3),
				cursor.getString(4)
				
				);
		// return contact
		return contact;
	}
	
	
	
	// Getting All Contacts
	public List<Contactlogs> getAllContactslogs() {
		List<Contactlogs> contactList = new ArrayList<Contactlogs>();
		// Select All Query
		String selectQuery = "SELECT  * FROM " + TABLE_CONTACTS_LOGS;

		SQLiteDatabase db = this.getWritableDatabase();
		Cursor cursor = db.rawQuery(selectQuery, null);

		// looping through all rows and adding to list
		if (cursor.moveToFirst()) {
			do {
				Contactlogs contact = new Contactlogs();
				contact.setID(Integer.parseInt(cursor.getString(0)));
				contact.setCardid(cursor.getString(1));
				contact.setShopid(cursor.getString(2));
				contact.setPoint(cursor.getString(3));
//				contact.setCreate(cursor.getString(4));
				contact.setStatus(cursor.getString(4));
				// Adding contact to list
				contactList.add(contact);
			} while (cursor.moveToNext());
		}

		// return contact list
		return contactList;
	}
	
	// Check Contacts
		public List<Contactlogs> newcontactlogs() {
			List<Contactlogs> contactList = new ArrayList<Contactlogs>();
			SQLiteDatabase db = this.getReadableDatabase();
			// Select All Query
			Cursor cursor = db.query(TABLE_CONTACTS_LOGS, new String[] { KEY_ID,
					KEY_CARDID,KEY_SHOPID, KEY_POINT  ,KEY_STATUS}, KEY_STATUS + "=?",
					new String[] { "new" }, null, null, null, null);

			// looping through all rows and adding to list
			if (cursor.moveToFirst()) {
				do {
					Contactlogs contact = new Contactlogs();
					contact.setID(Integer.parseInt(cursor.getString(0)));
					contact.setCardid(cursor.getString(1));
					contact.setShopid(cursor.getString(2));
					contact.setPoint(cursor.getString(3));
//					contact.setCreate(cursor.getString(4));
					contact.setStatus(cursor.getString(4));
					// Adding contact to list
					contactList.add(contact);
				} while (cursor.moveToNext());
			}

			// return contact list
			return contactList;
		}
	

	// Updating single contact
	public int updateContact(Contactlogs contact) {
		SQLiteDatabase db = this.getWritableDatabase();

		ContentValues values = new ContentValues();
		values.put(KEY_ID, contact.getID()); // Contact id
		values.put(KEY_CARDID, contact.getCardid()); // Contact Card id
		values.put(KEY_SHOPID, contact.getCardid()); // Contact Shop id
		values.put(KEY_POINT, contact.getPoint()); // Contact Point
		values.put(KEY_STATUS, contact.getStatus()); // Contact Update
		

		// updating row
		return db.update(TABLE_CONTACTS_LOGS, values, KEY_ID + " = ?",
				new String[] { String.valueOf(contact.getID()) });
	}

	// Deleting single contact
	public void deleteContact(Contactlogs contact) {
		SQLiteDatabase db = this.getWritableDatabase();
		db.delete(TABLE_CONTACTS_LOGS, KEY_ID + " = ?",
				new String[] { String.valueOf(contact.getID()) });
		db.close();
	}


	// Getting contacts Count
	public int getContactsCountlogs() {
		String countQuery = "SELECT  * FROM " + TABLE_CONTACTS_LOGS;
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.rawQuery(countQuery, null);
		cursor.close();

		// return count
		return cursor.getCount();
	}


}
