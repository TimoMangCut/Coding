package com.mycompany.muonsach;

import java.util.HashMap;
import java.util.Map.Entry;
import java.util.Scanner;

public class Data {

    Scanner input = new Scanner(System.in);
    HashMap<String, String> data = new HashMap<>();
    User user = new User();
    Book book = new Book();

    public Data() {
        user.add();
        book.addBook();
    }

    void issuebook(String ID) {

        System.out.println("ban muon muon sach nao? ");
        String bookname = input.nextLine();
        if (book.Book.containsValue(bookname)) {
            int bookID = 0;
            for (Entry<Integer, String> entry : book.Book.entrySet()) {
                if (entry.getValue().equals(bookname)) {
                    bookID = entry.getKey();
                    break;
                }
            }
            book.Book.remove(bookID);
            data.put(ID, bookname);
            String name = user.user.get(ID);
            System.out.println("Name: " + name);
            System.out.println("Book: " + bookname);
            System.out.println("Book issued Congratulation");
        } else {
            System.out.println("Book doesn't exist");
            System.out.println("We have following Books:");
            System.out.println(book.Book);
        }
        for (Entry<String, String> vcc : data.entrySet()) {
            System.out.println(vcc);
        }
    }

    void returnbook(String ID) {
        if (data.containsKey(ID)) {
            System.out.println("Enter book to return!");
            String namebook = input.nextLine();
            int IDbook = 0;
            for (Entry<Integer, String> entry : book.Book.entrySet()) {
                if (entry.getValue().equals(namebook)) {
                    IDbook = entry.getKey();
                    break;
                }
            }
            if (data.containsValue(namebook)) {
                data.remove(ID);
                book.Book.put(IDbook, namebook);
                String name = user.user.get(ID);
                System.out.println("Name: " + name);
                System.out.println("Book: " + namebook);
                System.out.println(namebook + " was returned");
            } else {
                System.out.println("Khong co cuon sach nao co ten nhu vay!");
            }

        } else {
            System.out.println("Ban chua muon cuon sach nao!");
        }

    }

    void purpose(String ID) {
        Data data = new Data();
        String purpose;
        System.out.println("Ban muon muon sach hay tra sach?");
        purpose = input.nextLine();
        switch (purpose) {
            case "muon sach":
                data.issuebook(ID);
                break;
                case "tra sach":
                data.returnbook(ID);
                break;
            default:
                System.out.println("Vui long tra loi lai!");
                System.out.println("muon sach hay tra sach?");
                break;
        }
    }

}
