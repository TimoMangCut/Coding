package com.mycompany.muonsach;

import java.util.Scanner;

public class Main {

    static Data data = new Data();

    public static void main(String[] args) {
        Data d1 = new Data();
        User user = new User();
        user.add();
        Scanner input = new Scanner(System.in);
        System.out.println("Enter your ID: ");
        String ID = input.nextLine();
        if (user.user.containsKey(ID)) {
            d1.purpose(ID);
        } else {
            System.out.println("Thong tin cua ban khong thuoc he thong thu vien cua chung toi.");
            System.out.println("Ban co muon lam the thanh vien khong?");
            String cautraloi = input.nextLine();
            if (cautraloi.equals("co")) {
                user.adduser();
                d1.issuebook(ID);
            } else if (cautraloi.equals("yes")) {
                user.adduser();
                d1.issuebook(ID);
            } else {
                System.out.println("Cam on ban da den thu vien cua chung toi!");
            }
        }
    }
}
