
package com.mycompany.muonsach;

import java.util.HashMap;
import java.util.Scanner;

public class User {
    HashMap<String,String> user = new HashMap<>();
    Scanner input = new Scanner(System.in);
    void add() {
        user.put("DE160547", "Phuc");
        user.put("DS160184","Tram");
    }
    public void adduser() {
        System.out.println("Hay nhap ma so sinh vien cua ban: ");
        String ID = input.nextLine();
        System.out.println("Hay nhap ten cua ban: ");
        String Name = input.nextLine();
        user.put(ID, Name);
    }
    
}
