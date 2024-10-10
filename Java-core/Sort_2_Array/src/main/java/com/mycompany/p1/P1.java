//Nội dung : Nhập vào 2 mảng giá trị số nguyên và sẽ tự sắp xếp theo thứ tự từ bé đến lớn!

package com.mycompany.p1;

import java.util.ArrayList;
import java.util.Collection;
import java.util.Collections;
import java.util.Scanner;

public class P1 {
    ArrayList<Integer> a = new ArrayList<>();
    ArrayList<Integer> b = new ArrayList<>();
    Scanner input = new Scanner(System.in);

    public void setA(ArrayList<Integer> a) {
        this.a = a;
    }

    public void setB(ArrayList<Integer> b) {
        this.b = b;
    }
   public void data() {
       System.out.println("Ban muon mang a co bao nhieu so?");
            int num = input.nextInt();
            for(int i = 1; i <= num; i++ ){
                System.out.println("Hay nhap vao so thu " + i + " ");
                int nhapso = input.nextInt();
                a.add(nhapso);
            }
        System.out.println("Ban muon mang b co bao nhieu so?");
            int num1 = input.nextInt();
            for (int i = 1; i <= num1; i++){
                System.out.println("Hay nhap vao so thu " + i + " ");
                int nhapso1 = input.nextInt();
                b.add(nhapso1);
            }
        a.addAll(b);
        Collections.sort(a);
        System.out.println(a);
   }
}
